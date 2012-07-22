<?php

namespace NSM\Bundle\NSMDateTimeBundle\Utility;

use DateTime;

class DateTime
{
    public $current_date = null;

    /**
     * @param DateTime $current
     * @return DateTime $end
     */
    public function getEndOfDay(DateTime $current)
    {
        $currentYear = $current->format('Y');
        $currentMonth = $current->format('m');
        $currentDay = $current->format('d');
        $end = new DateTime();
        $end->setDate($currentYear, $currentMonth, $currentDay);
        $end->setTime(23, 59, 59);
        return $end;
    }

    /**
     * If end of week is saturday, then offset is "Saturday"
     * If end of week is sunday, then offset is "Sunday"
     * If end of week is friday, then offset is "Friday"
     *
     * @param DateTime $current
     * @param string $endDay
     * @return DateTime $start
     */
    public function getEndOfWeek(DateTime $current, $endDay = "Saturday")
    {
        $endDay = ucfirst($endDay);

        $end = new DateTime();
        $end->setTimestamp($current->getTimestamp());

        $currentDay = $current->format('l');
        if ($currentDay != $endDay) {
            $end->modify("Next ".$endDay);
        }
        $end->setTime(23, 59, 59);
        return $end;
    }

    /**
     * @param DateTime $current
     * @return DateTime $end
     */
    public function getEndOfMonth(DateTime $current)
    {
        $end = $this->getNextMonth($current);
        $end->modify("-1 second");
        return $end;
    }

    /**
     * @param DateTime $current
     * @return DateTime $next
     */
    public function getNextMonth(DateTime $current)
    {
        $currentYear = $current->format('Y');
        $currentMonth = $current->format('m');
        $nextMonth = new DateTime();
        $nextMonth->setDate($currentYear, $currentMonth + 1, 1);
        $nextMonth->setTime(0, 0, 0);
        return $nextMonth;
    }

    /**
     * @param DateTime $current
     * @return DateTime $start
     */
    public function getStartOfDay(DateTime $current)
    {
        $currentYear = $current->format('Y');
        $currentMonth = $current->format('m');
        $currentDay = $current->format('d');
        $start = new DateTime();
        $start->setDate($currentYear, $currentMonth, $currentDay);
        $start->setTime(0, 0, 0);
        return $start;
    }

    /**
     * @param DateTime $current
     * @return DateTime $start
     */
    public function getStartOfMonth(DateTime $current)
    {
        $currentYear = $current->format('Y');
        $currentMonth = $current->format('m');
        $start = new DateTime();
        $start->setDate($currentYear, $currentMonth, 1);
        $start->setTime(0, 0, 0);
        return $start;
    }

    /**
     * If start of week is sunday, then offset is "Sunday"
     * If start of week is monday, then offset is "Monday"
     * If start of week is saturday, then offset is "Saturday"
     *
     * @param DateTime $current
     * @param string $startDay
     * @return DateTime $start
     */
    public function getStartOfWeek(DateTime $current, $startDay = "Sunday")
    {
        $startDay = ucfirst($startDay);

        $start = new DateTime();
        $start->setTimestamp($current->getTimestamp());

        $currentDay = $current->format('l');
        if ($currentDay != $startDay) {
            $start->modify("Last ".$startDay);
        }
        $start->setTime(0, 0, 0);
        return $start;
    }

    /**
     * Check if a Datetime object is within two other DateTime objects
     * @param  DateTime $date  [description]
     * @param  DateTime $start [description]
     * @param  DateTime $end   [description]
     * @return boolean
     */
    public function isWithinDates(DateTime $date, DateTime $start, DateTime $end)
    {
        return ($date >= $start && $date <= $end);
    }

    public function isToday(DateTime $date) 
    {
        return $this->isDay($date);
    }

    public function isTomorrow(DateTime $date) 
    {
        return $this->isDay($date,'+1');
    }

    public function isYesterday(DateTime $date) 
    {
        return $this->isDay($date,'-1');
    }

    public function isDay(DateTime $date, $n = false)
    {
        $now = new DateTime($this->current_date);
        if($n) $now->modify($n.' days');
        $start = $this->getStartOfDay($now);
        $end = $this->getEndOfDay($now);
        return $this->isWithinDates($date,$start,$end);
    }

    public function isWeek(DateTime $date, $n = false) 
    {
        $now = new DateTime($this->current_date);
        if($n) {
            $now->modify($n.' weeks');
        }
        $start = $this->getStartOfWeek($now);
        $end = $this->getEndOfWeek($now);
        return $this->isWithinDates($date,$start,$end);
    }

    public function isThisWeek(DateTime $date)
    {
        return $this->isWeek($date);
    }

    public function isNextWeek(DateTime $date)
    {
        return $this->isWeek($date,'+1');
    }

    public function isLastWeek(DateTime $date)
    {
        return $this->isWeek($date,'-1');
    }

    public function isMonth(DateTime $date, $n = false) 
    {
        $now = new DateTime($this->current_date);
        if($n) $now->modify($n.' months');
        $start = $this->getStartOfMonth($now);
        $end = $this->getEndOfMonth($now);
        return $this->isWithinDates($date,$start,$end);
    }

    public function isThisMonth(DateTime $date)
    {
        return $this->isMonth($date);
    }

    public function isLastMonth(DateTime $date)
    {
        return $this->isMonth($date,'-1');
    }

    public function isNextMonth(DateTime $date)
    {
        return $this->isMonth($date,'+1');
    }
}