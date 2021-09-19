<?php

namespace Shimoning\Deadline;

use Carbon\Carbon;

class NextMonthFirstBusinessDay extends Deadline
{
    /**
     * Setting first day of month
     *
     * @var integer
     */
    private $firstDayOfMonth = 1;

    public function __invoke(int $hours = 0, int $minutes = 0, int $seconds = 0): Carbon
    {
        // Set behavior
        $this->setBehaviorIfNotWeekday(1);

        // Move day
        $this->setDate(
            $this->date->clone()
                ->addMonth()                        // 翌月
                ->setDay($this->firstDayOfMonth)    // 開始日
        );

        return $this->get($hours, $minutes, $seconds);
    }

    /**
     * Set first day of month
     *
     * @param integer $days
     * @return void
     */
    public function setFirstDayOfMonth($days = 1)
    {
        if ($days > 0) {
            $this->firstDayOfMonth = $days;
        }
    }
}
