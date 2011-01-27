<?php
/**
 * Atom framework
 * 
 * @version $Id$
 * @copyright Marc Steinert
 */
 
/**
 * @example
 * 
 *  $start = new DateTime('2009-11-16 12:12:12');
 *  $end = new DateTime('2020-12-31 23:59:59');
 * 
 *  $interval = DateInterval::createFromDateString('+1 year');
 *  $df = new Atom_Date_FilterIterator(
 *      new DatePeriod($start, $interval, $end),
 *      $start
 *  );
 * 
 *  foreach ($df as $dt) {
 *      echo $dt->format( "l Y-m-d H:i:s\n" ), "<br />";
 *  }
 * 
 * @package     Atom Framework
 * @author      Marc Steinert <marc@bithub.net>
 */
class Atom_Date_FilterIterator extends FilterIterator {
    
    /**
     * 
     * 
     * @var int
     */
    private $_starttime;
    
    
    /**
     * 
     * 
     * @param   DateInterval    $inner
     * @param   DateTime        $start
     * @return  Atom_Date_FilterIterator
     */
    public function __construct(DatePeriod $inner, DateTime $start) {
        $this->_starttime = $start->getTimestamp();
        
        parent::__construct(new IteratorIterator($inner));
    }
    
    public function accept() {
        return (
            $this->_starttime < $this->current()->getTimestamp()
        );
    }
}
