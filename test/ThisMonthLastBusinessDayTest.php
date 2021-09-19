<?php

use PHPUnit\Framework\TestCase;
use Shimoning\Deadline\ThisMonthLastBusinessDay;

class ThisMonthLastBusinessDayTest extends TestCase
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

    public function test20200430_000000()
    {
        // init
        $deadline = new ThisMonthLastBusinessDay(2020, 4, 20);

        // get deadline
        $date = $deadline();
        $this->assertEquals(2020, $date->year);
        $this->assertEquals(4, $date->month);
        $this->assertEquals(30, $date->day);
        $this->assertEquals(0, $date->hour);
        $this->assertEquals(0, $date->minute);
        $this->assertEquals(0, $date->second);
    }

    public function test20200429_000000()
    {
        // init
        $deadline = new ThisMonthLastBusinessDay(2020, 4, 20);

        // set sub days
        $deadline->setSubDays(1);

        // get deadline
        $date = $deadline();
        $this->assertEquals(2020, $date->year);
        $this->assertEquals(4, $date->month);
        $this->assertEquals(29, $date->day);
        $this->assertEquals(0, $date->hour);
        $this->assertEquals(0, $date->minute);
        $this->assertEquals(0, $date->second);
    }

    public function test20200424_000000()
    {
        // init
        $deadline = new ThisMonthLastBusinessDay(2020, 4, 20);

        // set sub days
        $deadline->setSubDays(4);

        // get deadline
        $date = $deadline();
        $this->assertEquals(2020, $date->year);
        $this->assertEquals(4, $date->month);
        $this->assertEquals(24, $date->day);
        $this->assertEquals(0, $date->hour);
        $this->assertEquals(0, $date->minute);
        $this->assertEquals(0, $date->second);
    }
}
