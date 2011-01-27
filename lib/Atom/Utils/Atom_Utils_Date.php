<?php

class Atom_Utils_Date {

    /**
     * Enforce static behavior
     *
     */
    private function __construct() { }

    /**
     * Returns an ordered array with translated month names.
     *
     * @return  array
     */
    public static function getMonthArray() {
        return array(
            __('January'),
            __('February'),
            __('March'),
            __('April'),
            __('May'),
            __('June'),
            __('July'),
            __('August'),
            __('September'),
            __('October'),
            __('November'),
            __('December')
        );
    }

    public static function getMonthShortArray() {
        $months = self::getMonthArray();

        for ($i = 0, $len = 12; $i < 12; ++$i) {
            $months[$i] = mb_substr($months[$i], 0, 3);
        }

        return $months;
    }

    /**
     * Returns an ordered array with translated day names.
     *
     * @return  array
     */
    public static function getDayArray() {
        return array(
            __('Sunday'),
            __('Monday'),
            __('Tuesday'),
            __('Wednesday'),
            __('Thursday'),
            __('Friday'),
            __('Saturday')
        );
    }

    /**
     * @return array
     */
    public static function getDayShortArray() {
        return array(
            __('Sun'),
            __('Mon'),
            __('Tue'),
            __('Wed'),
            __('Thu'),
            __('Fri'),
            __('Sat')
        );
    }
}
