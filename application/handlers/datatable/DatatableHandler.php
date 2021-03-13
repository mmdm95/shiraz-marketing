<?php

/**
 * @see https://github.com/DataTables/DataTables/blob/de73685996c6c666e1850668c72e34d492f22150/examples/server_side/scripts/ssp.class.php
 */

namespace application\handlers\datatable;

use application\handlers\StringConverter;

class DatatableHandler
{
    /**
     * @param array $request
     * @param array $columns
     * @param \Closure $callback
     * @return array
     */
    public static function handle(array $request, array $columns, \Closure $callback): array
    {
        $cols = self::columnsNAliases($columns);
        [$where, $bindValues] = self::filter($request, $columns);
        [$limit, $offset] = self::limit($request);
        $order = self::order($request, $columns);

        $res = $callback($cols, $where, $bindValues, $limit, $offset, $order);
        if (is_array($res) && 3 === count($res)) {
            [$data, $recordsFiltered, $recordsTotal] = $res;
        } else {
            [$data, $recordsFiltered, $recordsTotal] = [[], 0, 0];
        }

        /*
         * Output
         */
        return [
            "draw" => isset ($request['draw']) ? intval($request['draw']) : 0,
            "recordsTotal" => intval($recordsTotal),
            "recordsFiltered" => intval($recordsFiltered),
            "data" => self::dataOutput($columns, $data),
        ];
    }

    /**
     * @param $request
     * @param $columns
     * @return array
     */
    private static function filter($request, $columns): array
    {
        $globalSearch = [];
        $columnSearch = [];
        $dtColumns = self::pluck($columns, 'dt');
        $bindValues = [];
        $bindCounter = 0;

        if (isset($request['search']) && $request['search']['value'] != '') {
            $str = $request['search']['value'];

            for ($i = 0, $ien = count($request['columns']); $i < $ien; $i++) {
                $requestColumn = $request['columns'][$i];
                $columnIdx = array_search($requestColumn['data'], $dtColumns);
                $column = $columns[$columnIdx];

                if ($requestColumn['searchable'] == 'true') {
                    if (!empty($column['db'])) {
                        // english
                        $binding = 'binding' . $bindCounter++;
                        $bindValues[$binding] = '%' . StringConverter::toEnglish($str) . '%';
                        $phrase = '(' . $column['db'] . " LIKE :" . $binding . ' OR ';

                        // persian
                        $binding = 'binding' . $bindCounter++;
                        $bindValues[$binding] = '%' . StringConverter::toPersian($str) . '%';
                        $phrase .= $column['db'] . " LIKE :" . $binding . ' OR ';

                        // arabic
                        $binding = 'binding' . $bindCounter++;
                        $bindValues[$binding] = '%' . StringConverter::toArabic($str) . '%';
                        $phrase .= $column['db'] . " LIKE :" . $binding . ')';

                        $globalSearch[] = $phrase;
                    }
                }
            }
        }

        // Individual column filtering
        if (isset($request['columns'])) {
            for ($i = 0, $ien = count($request['columns']); $i < $ien; $i++) {
                $requestColumn = $request['columns'][$i];
                $columnIdx = array_search($requestColumn['data'], $dtColumns);
                $column = $columns[$columnIdx];

                $str = $requestColumn['search']['value'];

                if ($requestColumn['searchable'] == 'true' &&
                    $str != '') {
                    if (!empty($column['db'])) {
                        $binding = 'binding' . $bindCounter++;
                        $bindValues[$binding] = '%' . $str . '%';
                        $columnSearch[] = $column['db'] . " LIKE :" . $binding;
                    }
                }
            }
        }

        // Combine the filters into a single string
        $where = '';

        if (count($globalSearch)) {
            $where = '(' . implode(' OR ', $globalSearch) . ')';
        }

        if (count($columnSearch)) {
            $where = $where === '' ?
                implode(' AND ', $columnSearch) :
                $where . ' AND ' . implode(' AND ', $columnSearch);
        }

        return [$where, $bindValues];
    }

    /**
     * @param $request
     * @return array
     */
    private static function limit($request): array
    {
        $limit = [null, 0];

        if (isset($request['start']) && $request['length'] != -1) {
            $limit = [intval($request['length']), intval($request['start'])];
        }

        return $limit;
    }

    /**
     * @param $request
     * @param $columns
     * @return array
     */
    private static function order($request, $columns): array
    {
        $orderBy = [];

        if (isset($request['order']) && count($request['order'])) {
            $dtColumns = self::pluck($columns, 'dt');

            for ($i = 0, $ien = count($request['order']); $i < $ien; $i++) {
                // Convert the column index into the column data property
                $columnIdx = intval($request['order'][$i]['column']);
                $requestColumn = $request['columns'][$columnIdx];

                $columnIdx = array_search($requestColumn['data'], $dtColumns);
                $column = $columns[$columnIdx];

                if ($requestColumn['orderable'] == 'true') {
                    $dir = $request['order'][$i]['dir'] === 'asc' ?
                        'ASC' :
                        'DESC';

                    $orderBy[] = $column['db'] . ' ' . $dir;
                }
            }
        }

        return $orderBy;
    }

    /**
     * @param $columns
     * @param $data
     * @return array
     */
    private static function dataOutput($columns, $data): array
    {
        $out = [];

        for ($i = 0, $ien = count($data); $i < $ien; $i++) {
            $row = [];

            for ($j = 0, $jen = count($columns); $j < $jen; $j++) {
                $column = $columns[$j];

                // Is there a formatter?
                if (isset($column['formatter'])) {
                    if (empty($column['db_alias'])) {
                        $row[$column['dt']] = $column['formatter']($data[$i]);
                    } else {
                        $row[$column['dt']] = $column['formatter']($data[$i][$column['db_alias']], $data[$i]);
                    }
                } else {
                    if (!empty($column['db_alias'])) {
                        $row[$column['dt']] = $data[$i][$columns[$j]['db_alias']];
                    } else {
                        $row[$column['dt']] = "";
                    }
                }
            }

            $out[] = $row;
        }

        return $out;
    }

    /**
     * Get columns with aliases
     *
     * @param $columns
     * @return array
     */
    private static function columnsNAliases($columns): array
    {
        $cols = [];

        for ($i = 0, $len = count($columns); $i < $len; $i++) {
            if (empty($columns[$i]['db'])) {
                continue;
            }
            $col = $columns[$i]['db'];
            $alias = $columns[$i]['db_alias'] ?? null;
            $cols[$i] = $col . (!empty($alias) ? " AS {$alias}" : '');
        }

        return $cols;
    }

    /**
     * @param $a
     * @param $prop
     * @return array
     */
    private static function pluck($a, $prop): array
    {
        $out = [];

        for ($i = 0, $len = count($a); $i < $len; $i++) {
            if (!isset($a[$i][$prop]) || empty($a[$i][$prop])) {
                continue;
            }
            //removing the $out array index confuses the filter method in doing proper binding,
            //adding it ensures that the array data are mapped correctly
            $out[$i] = $a[$i][$prop];
        }

        return $out;
    }
}