<?php

namespace NSM\Bundle\DateTimeBundle\Utility;

use DateTime;

class DateTimeHelper
{
    public $current_date = null;

    /**
     * Get the end of the day
     *
     * @param \DateTime $current
     * @return \DateTime
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
     * Get the end of the week
     *
     * If end of week is saturday, then offset is "Saturday"
     * If end of week is sunday, then offset is "Sunday"
     * If end of week is friday, then offset is "Friday"
     *
     * @param \DateTime $current
     * @param string $endDay
     * @return \DateTime
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
     * Get the end of the month
     *
     * @param \DateTime $current
     * @return \DateTime
     */
    public function getEndOfMonth(DateTime $current)
    {
        $end = $this->getNextMonth($current);
        $end->modify("-1 second");
        return $end;
    }

    /**
     * Get the start of the next month
     *
     * @param \DateTime $current
     * @return \DateTime
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
     * Get the start of the day
     *
     * @param \DateTime $current
     * @return \DateTime
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
     * Get the start of the month
     *
     * @param \DateTime $current
     * @return \DateTime
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
     * Get the start of the week
     *
     * If start of week is sunday, then offset is "Sunday"
     * If start of week is monday, then offset is "Monday"
     * If start of week is saturday, then offset is "Saturday"
     *
     * @param \DateTime $current
     * @param string $startDay
     * @return \DateTime
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
     *
     * @param \DateTime $date
     * @param \DateTime $start
     * @param \DateTime $end
     * @return bool
     */
    public function isWithinDates(DateTime $date, DateTime $start, DateTime $end)
    {
        return ($date >= $start && $date <= $end);
    }

    /**
     * Is the date today?
     *
     * @param \DateTime $date
     * @return bool
     */
    public function isToday(DateTime $date) 
    {
        return $this->isDay($date);
    }

    /**
     * Is the date tomorrow?
     *
     * @param \DateTime $date
     * @return bool
     */
    public function isTomorrow(DateTime $date)
    {
        return $this->isDay($date,'+1');
    }

    /**
     * Is the date yesterday?
     *
     * @param \DateTime $date
     * @return bool
     */
    public function isYesterday(DateTime $date)
    {
        return $this->isDay($date,'-1');
    }

    /**
     * @param \DateTime $date
     * @param bool $n
     * @return bool
     */
    public function isDay(DateTime $date, $n = false)
    {
        $now = new DateTime($this->current_date);
        if($n) $now->modify($n.' days');
        $start = $this->getStartOfDay($now);
        $end = $this->getEndOfDay($now);
        return $this->isWithinDates($date,$start,$end);
    }

    /**
     * Is the date this week?
     *
     * @param \DateTime $date
     * @return bool
     */
    public function isThisWeek(DateTime $date)
    {
        return $this->isWeek($date);
    }

    /**
     * Is the date next week?
     *
     * @param \DateTime $date
     * @return bool
     */
    public function isNextWeek(DateTime $date)
    {
        return $this->isWeek($date,'+1');
    }

    /**
     * Is the date last week?
     *
     * @param \DateTime $date
     * @return bool
     */
    public function isLastWeek(DateTime $date)
    {
        return $this->isWeek($date,'-1');
    }

    /**
     * @param \DateTime $date
     * @param bool $n
     * @return bool
     */
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

    /**
     * Is the date this month?
     *
     * @param \DateTime $date
     * @return bool
     */
    public function isThisMonth(DateTime $date)
    {
        return $this->isMonth($date);
    }

    /**
     * Is the date last month?
     *
     * @param \DateTime $date
     * @return bool
     */
    public function isLastMonth(DateTime $date)
    {
        return $this->isMonth($date,'-1');
    }

    /**
     * Is the date next month?
     *
     * @param \DateTime $date
     * @return bool
     */
    public function isNextMonth(DateTime $date)
    {
        return $this->isMonth($date,'+1');
    }

    /**
     * @param \DateTime $date
     * @param bool $n
     * @return bool
     */
    public function isMonth(DateTime $date, $n = false)
    {
        $now = new DateTime($this->current_date);
        if($n) $now->modify($n.' months');
        $start = $this->getStartOfMonth($now);
        $end = $this->getEndOfMonth($now);
        return $this->isWithinDates($date,$start,$end);
    }
}