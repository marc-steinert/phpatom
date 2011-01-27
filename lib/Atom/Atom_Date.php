<?php
/**
 * Atom framework
 *
 * @version $Id$
 * @copyright Marc Steinert
 */

/**
 * Registry for config variables used within Atom.
 *
 * @uses        Atom_RegistryAbstract
 * @package     Atom Framework
 * @author      Marc Steinert <marc@bithub.net>
 */
class Atom_Date extends DateTime implements Atom_Db_ISQLValue {

    /**
     * Amount of seconds of a single day.
     *
     * @var int
     */
    const SECONDS_DAY = 86400;
    
    /**
     * Amount of seconds in an hour
     * 
     * @var     int
     */
    const SECONDS_HOUR = 3600;

    /**
     *
     * @throws  Atom_ArgumentException
     *
     * @param   mixed $time
     * @return  Atom_Date
     */
    public function __construct($time) {
        try {
            if (ctype_digit($time)) {
                $time = date(DateTime::ISO8601, $time);
            }

            parent::__construct($time);
        } catch (Exception $e) {
            // Rethrow Atom framework exception
            throw new Atom_ArgumentException(
                __('Invalid date given.')
            );
        }
    }
    
    public function format($formatString) {
         if (parent::format('Y') < 1900) {
            return self::getNullDate($formatString);
        }
        
        return parent::format($formatString);
    }
    
    public function toSql() {
        return $this->format('Y-m-d H:i:s');
    }
    
    public function __toString() {
        return $this->format('Y-m-d H:i:s');
    }
    
    /**
     * 
     * 
     * @return  Atom_Date
     */
    public function toUtc() {
        $offset = $this->getOffset();
        $pUtcDate = clone $this;
        $pUtcDate->modify($this->getOffset().' seconds');
        
        return $pUtcDate;
    }
    
    /**
     * Converts time to zulu time
     * 
     * @return  string
     */
    public function toZulu() {
        $pUtcDate = $this->toUtc();
        $tStamp = $pUtcDate->toTimestamp();
        
        return (
            date('Ymd', $tStamp).'T'.date('His', $tStamp).'Z'
        );
    }

    public function isInThePast() {
        return (
            $this->toTimestamp() < time()
        );
    }

    /**
     * Converts Date object to timestamp.
     *
     */
    public function toTimestamp() {
        return strtotime($this->toSql());
    }

    /**
     * Format:  D, d M Y H:i:s O
     *
     * @return  string
     */
	public function toRss() {
		return $this->format(DateTime::RSS);
    }

    /**
     * Returns ISO8601 date string.
     *
     * Format is: Y-m-d\TH:i:sO
     *
     * @return  string
     */
    public function toISO8601() {
        return $this->format(DateTime::ISO8601);
    }

    /**
     * @return Atom_Date
     */
    public static function getNow() {
        return new self('now');
    }

    /**
     * @return  int
     */
    public function diffSeconds(Atom_Date $pDate) {
        $timestamp1 = $this->toTimestamp();
        $timestamp2 = $pDate->toTimestamp();

        $diff = 0;

        if ($timestamp1 >= $timestamp2) {
            $diff = $timestamp1 - $timestamp2;
        } else {
            $diff = $timestamp2 - $timestamp1;
        }

        return $diff;
    }

    /**
     * Gets an textual
     *
     * @param Atom_Date $pDate
     * @return string
     */
    public static function diffString(Atom_Date $pDate) {
        $pNow = Atom_Date::getNow();

        $diff = $pNow->toTimestamp() - $pDate->toTimestamp();

        if ($diff == 0) return __('now');

        if ($diff > 0) {
            $day_diff = floor($diff / 86400);

            if($day_diff == 0) {
                // Difference within a day
                if ($diff < 60)
                    return __('just now');

                if ($diff < 3600)
                    return __('!minutes minutes ago', array('!minutes' => floor($diff / 60)));

                if ($diff < 86400)
                    return __('!hours hours ago', array('!hours' => floor($diff / 3600)));
            }

            if ($day_diff == 1)
                return __('Yesterday');

            if ($day_diff < 7)
                return __('!days days ago', array('!days' => ceil($day_diff / 7)));

            if ($day_diff < 31)
                return __('!weeks weeks ago', array('!weeks' => ceil($day_diff / 7)));

            if ($day_diff < 60)
                return __('last month');

            return $pDate->format('d Y');
        }

        // Date is in the future
        $diff = abs($diff);
        $day_diff = floor($diff / 86400);

        if($day_diff == 0) {
            // Difference within a day
            if ($diff < 120)
                return __('in a minute');

            if ($diff < 3600)
                return __('in %minutes minutes', array('%minutes' => floor($diff / 60)));

            if ($diff < 7200)
                return __('in an hour');

            if ($diff < 86400)
                return __('in %hours hours', array('%hours' => floor($diff / 3600)));
        }

        if ($day_diff == 1)
            return __('Tomorrow');

        if ($day_diff < 4)
            return __(date('l', $pDate->toTimestamp()));

        if ($day_diff < 7 + (7 - date('w')))
            return __('next week');

        if (ceil($day_diff / 7) < 4)
            return __('in %weeks weeks', array('%weeks' => ceil($day_diff / 7)));

        if (date('n', $ts) == date('n') + 1)
            return __('next month');

        return date('F Y', $ts);
    }

    public function getDateShort() {

    }

    public function getDateLong() {

    }

    public function getDateTimeLong() {
        return $this->format('m/d/Y H:i');
    }

    public function getDateTimeShort() {

    }
    
    private static function getNullDate($formatString) {
        $replace = array(
            'd' => '00',
            'Y' => '0000',
            'm' => '00',
            'y' => '00',
            'H' => '00',
            'i' => '00',
            's' => '00',
        );
        
        return str_replace(
            array_keys($replace),
            array_values($replace),
            $formatString
        );
    }
}
