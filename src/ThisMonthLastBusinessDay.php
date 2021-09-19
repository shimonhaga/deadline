<?php

namespace Shimoning\Deadline;

use Carbon\Carbon;

class ThisMonthLastBusinessDay extends Deadline
{
    /**
     * Setting to subtract days from base day
     *
     * @var integer
     */
    private $subDays = 0;

    public function __invoke(int $hours = 0, int $minutes = 0, int $seconds = 0): Carbon
    {
        // Set behavior
        $this->setBehaviorIfNotWeekday(-1);

        // Move day
        $this->setDate(
            $this->date->clone()
                ->lastOfMonth() // 月末
                ->subDay($this->subDays)
        );

        return $this->get($hours, $minutes, $seconds);
    }

    /**
     * Set setting to subtract days from base day
     *
     * @param integer $days
     * @return void
     */
    public function setSubDays($days = 0)
    {
        $this->subDays = abs($days);
    }
}
