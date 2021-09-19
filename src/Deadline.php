<?php

namespace Shimoning\Deadline;

use Carbon\Carbon;

class Deadline
{
    const ADD_DAY_IF_NOT_WEEKDAY = 1;
    const SUB_DAY_IF_NOT_WEEKDAY = -1;

    /**
     * date
     *
     * @var Carbon
     */
    protected $date;

    /**
     * Holiday setting
     *
     * @var array
     */
    protected $holidays = [];

    /**
     * Behavior setting if date is not weekday
     *
     * @var integer $type
     *   0 = none
     *   1 = add day
     *  -1 = sub day
     */
    protected $behaviorIfNotWeekday = 0;

    /**
     * Constructor
     *
     * @param int $year
     * @param int $month
     * @param int $day
     */
    public function __construct($year, $month, $day)
    {
        $this->date = $year && $month && $day
            ? Carbon::create($year, $month, $day)
            : Carbon::now();
    }

    /**
     * Setter
     *
     * @param Carbon $date
     * @return Carbon
     */
    public function setDate(Carbon $date): void
    {
        if (!empty($date) && $date instanceof Carbon) {
            $this->date = $date;
        }
    }

    /**
     * Getter
     *
     * @return Carbon
     */
    public function getDate(): Carbon
    {
        return $this->date;
    }

    /**
     * Set holiday setting
     *
     * @param array $holidays
     * @return void
     */
    public function setHolidays($holidays = [])
    {
        $this->holidays = [];

        foreach ($holidays as $holiday) {
            if (!($holiday instanceof Carbon)) {
                $holiday = Carbon::parse($holiday);
            }
            $this->holidays[] = $holiday;
        }
    }

    /**
     * Get status that date is holiday
     *
     * @return boolean
     */
    public function isHoliday(): bool
    {
        foreach ($this->holidays as $holiday) {
            if ($this->date->isSameDay($holiday)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Set weekend setting
     *
     * @param array $days
     * @return void
     */
    public function setWeekendDays($days = [
        Carbon::SATURDAY,
        Carbon::SUNDAY,
    ]) {
        // TODO: replace using macro case
        $this->date->setWeekendDays($days);
    }

    /**
     * Get status that date is weekend
     *
     * @return boolean
     */
    public function isWeekend(): bool
    {
        return $this->date->isWeekend();
    }

    /**
     * Set day for base
     *
     * @param string|int $day
     * @return void
     */
    public function setBaseDay($day)
    {
        if (\is_numeric(($day))) {
            $this->date->setDay($day);
        } else if ($day === 't') {
            $this->date->setDay($this->date->daysInMonth);
        }
    }

    /**
     * Set behavior type if date is not weekday
     *
     * @param integer $type
     *   0 = none
     *   1 = add day
     *  -1 = sub day
     * @return void
     */
    public function setBehaviorIfNotWeekday($type = 0)
    {
        $this->behaviorIfNotWeekday = $type;
    }

    /**
     * Get status that date is over now
     *
     * @return boolean
     */
    public function isExceeded(): bool
    {
        $now = Carbon::now();
        return $now->gt($this->date);
    }

    public function get(int $hours = 0, int $minutes = 0, int $seconds = 0)
    {
        // Check weekday
        if ($this->behaviorIfNotWeekday !== 0) {
            $method = $this->behaviorIfNotWeekday > 0 ? 'addDay' : 'subDay';

            // Check weekend
            while ($this->isWeekend()) {
                $this->date->{$method}();
            }

            // Check holiday
            while ($this->isHoliday()) {
                $this->date->{$method}();
            }
        }

        // Set time
        $this->date
            ->setHour($hours)
            ->setMinute($minutes)
            ->setSecond($seconds);

        return $this->date->clone();
    }
}
