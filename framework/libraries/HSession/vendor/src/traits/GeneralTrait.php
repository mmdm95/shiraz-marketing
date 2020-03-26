<?php

namespace HSession\Traits;


trait GeneralTrait
{
    use InstantiatorTrait, ValidatorTrait;

    /**
     * @param array|string $str
     * @param array|string $from
     * @param string $to
     * @return string
     */
    public function slashConverter(&$str, $from = ['\\', '/'], $to = DIRECTORY_SEPARATOR): string
    {
        if (is_array($str)) {
            $newStr = [];
            foreach ($str as $key => $value) {
                $newStr[$key] = $this->slashConverter($value, $from, $to);
            }
            return $newStr;
        }
        if (is_array($from)) {
            foreach ($from as $item) {
                $this->slashConverter($str, $item, $to);
            }
        }
        if (is_string($from)) {
            $str = str_replace($from, $to, $str);
        }
        return $str;
    }
}