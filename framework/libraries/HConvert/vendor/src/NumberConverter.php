<?php

namespace HConvert\Converter;


use HConvert\Traits\InstantiatorTrait;

class NumberConverter
{
    use InstantiatorTrait;

    /**
     * @var array $pesian_numbers
     */
    protected $persian_numbers = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];

    /**
     * @var array $pesian_decimal_numbers
     */
    protected $persian_decimal_numbers = ['&#1776;', '&#1777;', '&#1778;', '&#1779;', '&#1780;', '&#1781;', '&#1782;', '&#1783;', '&#1784;', '&#1785;'];

    /**
     * @var array $persian_specials
     */
    protected $persian_specials = ['ی', 'ک', 'ه'];

    /**
     * @var array $arabic_numbers
     */
    protected $arabic_numbers = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];

    /**
     * @var array $arabic_decimal_numbers
     */
    protected $arabic_decimal_numbers = ['&#1632;', '&#1633;', '&#1634;', '&#1635;', '&#1636;', '&#1637;', '&#1638;', '&#1639;', '&#1640;', '&#1641;'];

    /**
     * @var array $arabic_specials
     */
    protected $arabic_specials = ['ي', 'ك', 'ة'];

    /**
     * @var array $english_numbers
     */
    protected $english_numbers;

    public function __construct()
    {
        $this->english_numbers = range(0, 9);
    }

    /**
     * Convert some numbers to persian one,
     * also convert some arabic special characters to equivalent in persian
     *
     * @param array|string $str
     * @return array|string
     */
    public function toPersian($str)
    {
        if (is_array($str)) {
            $newArr = [];
            foreach ($str as $k => $v) {
                $newArr[$k] = $this->toPersian($str[$k]);
            }
            return $newArr;
        }

        $str = str_replace($this->arabic_numbers, $this->persian_numbers, $str);
        $str = str_replace($this->arabic_decimal_numbers, $this->persian_decimal_numbers, $str);
        $str = str_replace($this->arabic_specials, $this->persian_specials, $str);
        $str = str_replace($this->english_numbers, $this->persian_numbers, $str);

        return $str;
    }

    /**
     * Convert some numbers to arabic one,
     * also convert some persian special characters to equivalent in arabic
     *
     * @param array|string $str
     * @return array|string
     */
    public function toArabic($str)
    {
        if (is_array($str)) {
            $newArr = [];
            foreach ($str as $k => $v) {
                $newArr[$k] = $this->toArabic($str[$k]);
            }
            return $newArr;
        }

        $str = str_replace($this->persian_numbers, $this->arabic_numbers, $str);
        $str = str_replace($this->persian_decimal_numbers, $this->arabic_decimal_numbers, $str);
        $str = str_replace($this->persian_specials, $this->arabic_specials, $str);
        $str = str_replace($this->english_numbers, $this->arabic_numbers, $str);

        return $str;
    }

    /**
     * Convert some numbers to english one
     *
     * @param array|string $str
     * @return array|string
     */
    public function toEnglish($str)
    {
        if (is_array($str)) {
            $newArr = [];
            foreach ($str as $k => $v) {
                $newArr[$k] = $this->toEnglish($str[$k]);
            }
            return $newArr;
        }

        $str = str_replace($this->persian_numbers, $this->english_numbers, $str);
        $str = str_replace($this->arabic_numbers, $this->english_numbers, $str);

        return $str;
    }
}