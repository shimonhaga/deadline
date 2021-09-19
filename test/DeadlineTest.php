<?php

use PHPUnit\Framework\TestCase;
use Shimoning\Deadline\Deadline;
use Carbon\Carbon;

class DeadlineTest extends TestCase
{
    /**
     * Apr 2020
     *
     * Su Mo Tu We Th Fr Sa
     *           1  2  3  4
     *  5  6  7  8  9 10 11
     * 12 13 14 15 16 17 18
     * 19 20 21 22 23 24 25
     * 26 27 28 29 30
     *
     * 29: Showa no hi
     */

    public function test20200420_000000()
    {
        // normally
        $deadline = new Deadline(2020, 4, 20);

        // get deadline
        $date = $deadline->get();
        $this->assertEquals(2020, $date->year);
        $this->assertEquals(4, $date->month);
        $this->assertEquals(20, $date->day);
        $this->assertEquals(0, $date->hour);
        $this->assertEquals(0, $date->minute);
        $this->assertEquals(0, $date->second);
    }

    public function test20200420_120000()
    {
        $deadline = new Deadline(2020, 4, 20);

        // get deadline with hour
        $date = $deadline->get(12);
        $this->assertEquals(2020, $date->year);
        $this->assertEquals(4, $date->month);
        $this->assertEquals(20, $date->day);
        $this->assertEquals(12, $date->hour);
        $this->assertEquals(0, $date->minute);
        $this->assertEquals(0, $date->second);
    }

    public function test20200420_123000()
    {
        $deadline = new Deadline(2020, 4, 20);

        // get deadline with hour and minute
        $date = $deadline->get(12, 30);
        $this->assertEquals(2020, $date->year);
        $this->assertEquals(4, $date->month);
        $this->assertEquals(20, $date->day);
        $this->assertEquals(12, $date->hour);
        $this->assertEquals(30, $date->minute);
        $this->assertEquals(0, $date->second);
    }

    public function test20200420_112959()
    {
        $deadline = new Deadline(2020, 4, 20);

        // get deadline with hour
        $date = $deadline->get(11, 29, 59);
        $this->assertEquals(2020, $date->year);
        $this->assertEquals(4, $date->month);
        $this->assertEquals(20, $date->day);
        $this->assertEquals(11, $date->hour);
        $this->assertEquals(29, $date->minute);
        $this->assertEquals(59, $date->second);
    }

    public function test20200401_000000()
    {
        $deadline = new Deadline(2020, 4, 20);

        // change base day to first
        $deadline->setBaseDay(1);

        // get deadline
        $date = $deadline->get();
        $this->assertEquals(2020, $date->year);
        $this->assertEquals(4, $date->month);
        $this->assertEquals(1, $date->day);
        $this->assertEquals(0, $date->hour);
        $this->assertEquals(0, $date->minute);
        $this->assertEquals(0, $date->second);
    }

    public function test20200430_000000()
    {
        $deadline = new Deadline(2020, 4, 20);

        // change base day to last
        $deadline->setBaseDay('t');

        // get deadline
        $date = $deadline->get();
        $this->assertEquals(2020, $date->year);
        $this->assertEquals(4, $date->month);
        $this->assertEquals(30, $date->day);
        $this->assertEquals(0, $date->hour);
        $this->assertEquals(0, $date->minute);
        $this->assertEquals(0, $date->second);
    }

    public function test20200425_000000()
    {
        // Saturday
        $deadline = new Deadline(2020, 4, 25);

        // get deadline
        $date = $deadline->get();
        $this->assertEquals(2020, $date->year);
        $this->assertEquals(4, $date->month);
        $this->assertEquals(25, $date->day);
        $this->assertEquals(0, $date->hour);
        $this->assertEquals(0, $date->minute);
        $this->assertEquals(0, $date->second);
    }

    public function test20200427_000000()
    {
        // Saturday
        $deadline = new Deadline(2020, 4, 25);

        // slide next day
        $deadline->setBehaviorIfNotWeekday(Deadline::ADD_DAY_IF_NOT_WEEKDAY);

        // get deadline
        $date = $deadline->get();
        $this->assertEquals(2020, $date->year);
        $this->assertEquals(4, $date->month);
        $this->assertEquals(27, $date->day);
        $this->assertEquals(0, $date->hour);
        $this->assertEquals(0, $date->minute);
        $this->assertEquals(0, $date->second);
    }

    public function test20200424_000000()
    {
        // Saturday
        $deadline = new Deadline(2020, 4, 25);

        // slide prev day
        $deadline->setBehaviorIfNotWeekday(Deadline::SUB_DAY_IF_NOT_WEEKDAY);

        // get deadline
        $date = $deadline->get();
        $this->assertEquals(2020, $date->year);
        $this->assertEquals(4, $date->month);
        $this->assertEquals(24, $date->day);
        $this->assertEquals(0, $date->hour);
        $this->assertEquals(0, $date->minute);
        $this->assertEquals(0, $date->second);
    }

    public function test20200426_000000()
    {
        // Saturday
        $deadline = new Deadline(2020, 4, 25);

        // slide prev day
        $deadline->setBehaviorIfNotWeekday(Deadline::ADD_DAY_IF_NOT_WEEKDAY);

        // change weekend
        $deadline->setWeekendDays([
            Carbon::SATURDAY,
        ]);

        // get deadline
        $date = $deadline->get();
        $this->assertEquals(2020, $date->year);
        $this->assertEquals(4, $date->month);
        $this->assertEquals(26, $date->day);
        $this->assertEquals(0, $date->hour);
        $this->assertEquals(0, $date->minute);
        $this->assertEquals(0, $date->second);
    }

    public function test20200428_000000()
    {
        // Holiday
        $deadline = new Deadline(2020, 4, 29);

        // slide prev day
        $deadline->setBehaviorIfNotWeekday(Deadline::SUB_DAY_IF_NOT_WEEKDAY);

        // set holidays
        $deadline->setHolidays([
            '2020-04-29',
        ]);

        // get deadline
        $date = $deadline->get();
        $this->assertEquals(2020, $date->year);
        $this->assertEquals(4, $date->month);
        $this->assertEquals(28, $date->day);
        $this->assertEquals(0, $date->hour);
        $this->assertEquals(0, $date->minute);
        $this->assertEquals(0, $date->second);
    }

    public function testTodayIsExceeded()
    {
        // today
        $now = Carbon::now();
        $now->setHour(1);

        $deadline = new Deadline($now->year, $now->month, $now->day);

        // get deadline
        $date = $deadline->get();
        $this->assertEquals($now->year, $date->year);
        $this->assertEquals($now->month, $date->month);
        $this->assertEquals($now->day, $date->day);
        $this->assertEquals(0, $date->hour);
        $this->assertEquals(0, $date->minute);
        $this->assertEquals(0, $date->second);

        // exceeded
        $this->assertEquals(true, $deadline->isExceeded());
    }

    public function testTomorrowIsNotExceeded()
    {
        // tomorrow
        $now = Carbon::now();
        $now->addDay();
        $now->setHour(1);

        $deadline = new Deadline($now->year, $now->month, $now->day);

        // get deadline
        $date = $deadline->get();
        $this->assertEquals($now->year, $date->year);
        $this->assertEquals($now->month, $date->month);
        $this->assertEquals($now->day, $date->day);
        $this->assertEquals(0, $date->hour);
        $this->assertEquals(0, $date->minute);
        $this->assertEquals(0, $date->second);

        // exceeded
        $this->assertEquals(false, $deadline->isExceeded());
    }
}
