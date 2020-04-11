<?php
defined('BASE_PATH') OR exit('No direct script access allowed');

/*
 * phpcount.php Ver.1.1- An "anoymizing" hit counter.
 * Copyright (C) 2013  Taylor Hornby
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

/*
 * This PHP Class provides a hit counter that is able to track unique hits
 * without recording the visitor's IP address in the database. It does so by
 * recording the hash of the IP address and page name.
 *
 * By hashing the IP address with page name as salt, you prevent yourself from
 * being able to track a user as they navigate your site. You also prevent
 * yourself from being able to recover anyone's IP address without brute forcing
 * through all of the assigned IP address blocks in use by the internet.
 *
 * Contact: havoc AT defuse.ca
 * WWW:     https://defuse.ca/
 */

/* @see https://github.com/defuse/phpcount/blob/master/phpcount.php */
class PHPCount extends HModel
{
    /*
     * Defines how many seconds a hit should be rememberd for. This prevents the
     * database from perpetually increasing in size. Thirty days (the default)
     * works well. If someone visits a page and comes back in a month, it will be
     * counted as another unique hit.
     */
    const HIT_OLD_AFTER_SECONDS = 2592000; // default: 30 days.

    // Don't count hits from search robots and crawlers.
    const IGNORE_SEARCH_BOTS = true;

    // Don't count the hit if the browser sends the DNT: 1 header.
    const HONOR_DO_NOT_TRACK = false;

    // Tables name
    const TBL_HITS = 'hits';
    const TBL_NODUPES = 'nodupes';

    private $IP_IGNORE_LIST = array(
        '127.0.0.1',
    );

    private $DB = false;

    public function __construct()
    {
        parent::__construct();

        $this->DB = $this->getDb();
    }

    public function setDBAdapter($db)
    {
        $this->DB = $db;
        return $db;
    }

    /*
     * Adds a hit to a page specified by a unique $pageID string.
     */
    public function AddHit($pageID)
    {
        if (self::IGNORE_SEARCH_BOTS && $this->IsSearchBot())
            return false;
        if (in_array($_SERVER['REMOTE_ADDR'], $this->IP_IGNORE_LIST))
            return false;
        if (
            self::HONOR_DO_NOT_TRACK &&
            isset($_SERVER['HTTP_DNT']) && $_SERVER['HTTP_DNT'] == "1"
        ) {
            return false;
        }

        $this->Cleanup();
        if ($this->UniqueHit($pageID)) {
            $this->CountHit($pageID, true);
            $this->LogHit($pageID);
        }
        $this->CountHit($pageID, false);

        return true;
    }

    /*
     * Returns (int) the amount of hits a page has
     * $pageID - the page identifier
     * $unique - true if you want unique hit count
     */
    public function GetHits($pageID, $unique = false)
    {
        $select = $this->select();
        $select->cols(['hitcount'])->from(self::TBL_HITS)
            ->where('pageid=:pageid AND isunique=:isunique')
            ->bindValues(['pageid' => $pageID, 'isunique' => $unique]);
        $res = $this->db->fetchAll($select->getStatement(), $select->getBindValues());

        if (count($res)) {
            return (int)$res[0]['hitcount'] ?? 0;
        } else {
            //die("Missing hit count from database!");
            return 0;
        }
    }

    /*
     * Returns the total amount of hits to the entire website
     * When $unique is FALSE, it returns the sum of all non-unique hit counts
     * for every page. When $unique is TRUE, it returns the sum of all unique
     * hit counts for every page, so the value that's returned IS NOT the
     * amount of site-wide unique hits, it is the sum of each page's unique
     * hit count.
     */
    public function GetTotalHits($unique = false)
    {
        $select = $this->select();
        $select->cols(['hitcount'])->from(self::TBL_HITS)
            ->where('isunique=:isunique')
            ->bindValues(['isunique' => $unique]);
        $rows = $this->db->fetchAll($select->getStatement(), $select->getBindValues());

        $total = 0;
        foreach ($rows as $row) {
            $total += (int)$row['hitcount'];
        }
        return $total;
    }

    /*====================== PRIVATE METHODS =============================*/

    private function IsSearchBot()
    {
        // Of course, this is not perfect, but it at least catches the major
        // search engines that index most often.
        $keywords = array(
            'bot',
            'spider',
            'spyder',
            'crawlwer',
            'walker',
            'search',
            'yahoo',
            'holmes',
            'htdig',
            'archive',
            'tineye',
            'yacy',
            'yeti',
        );

        $agent = strtolower($_SERVER['HTTP_USER_AGENT']);

        foreach ($keywords as $keyword) {
            if (strpos($agent, $keyword) !== false)
                return true;
        }

        return false;
    }

    private function UniqueHit($pageID)
    {
        $ids_hash = $this->IDHash($pageID);

        $select = $this->select();
        $select->cols(['time'])->from(self::TBL_NODUPES)
            ->where('ids_hash=:ids_hash')
            ->bindValues(['ids_hash' => $ids_hash]);
        $res = $this->db->fetchAll($select->getStatement(), $select->getBindValues());

        if (count($res)) {
            if (($res[0]['time'] ?? 0) > time() - self::HIT_OLD_AFTER_SECONDS)
                return false;
            else
                return true;
        } else {
            return true;
        }
    }

    private function LogHit($pageID)
    {
        $ids_hash = $this->IDHash($pageID);

        $select = $this->select();
        $select->cols(['time'])->from(self::TBL_NODUPES)
            ->where('ids_hash=:ids_hash')
            ->bindValues(['pageid' => $ids_hash]);
        $res = $this->db->fetchAll($select->getStatement(), $select->getBindValues());

        $curTime = time();

        if (count($res)) {
            $update = $this->update();
            $update->cols([
                'time' => $curTime,
                'ids_hash' => $ids_hash,
            ])->table(self::TBL_NODUPES)
                ->where('ids_hash=:ids_hash')
                ->bindValues(['ids_hash' => $ids_hash]);

            $stmt = $this->DB->prepare($update->getStatement());
            $stmt->execute($update->getBindValues());
        } else {
            $insert = $this->insert();
            $insert->into(self::TBL_NODUPES)->addRow([
                'ids_hash' => $ids_hash,
                'time' => $curTime,
            ]);
            $stmt = $this->DB->prepare($insert->getStatement());
            $stmt->execute($insert->getBindValues());
        }
    }

    private function CountHit($pageID, $unique)
    {
        $stmt = $this->DB->prepare(
            'INSERT INTO ' . self::TBL_HITS . ' (pageid, isunique, hitcount) VALUES (:pageid, :isunique, 1) ' .
            'ON DUPLICATE KEY UPDATE hitcount = hitcount + 1'
        );
        $stmt->bindParam(':pageid', $pageID);
        $unique = $unique ? '1' : '0';
        $stmt->bindParam(':isunique', $unique);
        $stmt->execute();
    }

    private function IDHash($pageID)
    {
        $visitorID = $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT'];
        return hash("SHA256", $pageID . $visitorID);
    }

    private function Cleanup()
    {
        $last_interval = time() - self::HIT_OLD_AFTER_SECONDS;

        $delete = $this->delete();
        $delete->from(self::TBL_NODUPES)
            ->where('time<:time')->bindValues(['time' => $last_interval]);

        $stmt = $this->DB->prepare($delete->getStatement());
        $stmt->execute($delete->getBindValues());
    }
}
