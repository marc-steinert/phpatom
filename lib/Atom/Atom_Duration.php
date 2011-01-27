<?php

class Atom_Duration {

    /** @var Atom_Date */
    private $_start;

    /** @var Atom_Date */
    private $_end;


    public function __construct(Atom_Date $pStart, Atom_Date $pEnd) {
        $this->_start = $pStart;
        $this->_end = $pEnd;
    }

    /**
     *
     *
     * @return  int     Seconds
     */
    public function getDiffSeconds() {
        return (
            $this->_end->toTimestamp() - $this->_start->toTimestamp()
        );
    }

    /**
     *
     *
     * @param   int     $precision
     * @return  float
     */
    public function getDiffHours($precision = 0) {
        $precision = (int) $precision;

        return round(
            $this->getDiffSeconds() / ATOM_DATE::SECONDS_HOUR,
            $precision
        );
    }

    /**
     *
     *
     * @param mixed $precision
     * @return float
     */
    public function getDiffDays($precision = 0) {
        return round($this->getDiffHours(), $precision);
    }
}
