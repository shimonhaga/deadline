<?php

use PHPUnit\Framework\TestCase;
use Shimoning\Deadline\NextMonthFirstBusinessDay;

class NextMonthFirstBusinessDayTest extends TestCase
{
    /**
     * Jul 2021
     *
     * Su Mo Tu We Th Fr Sa
     *              1  2  3
     *  4  5  6  7  8  9 10
     * 11 12 13 14 15 16 17
     * 18 19 20 21 22 23 24
     * 25 26 27 28 29 30 31
     *
     * Aug 2021
     *
     * Su Mo Tu We Th Fr Sa
     *  1  2  3  4  5  6  7
     */

    public function test20210802_000000()
    {
        // init
        $deadline = new NextMonthFirstBusinessDay(2021, 7, 20);

        // get deadline
        $date = $deadline();
        $this->assertEquals(2021, $date->year);
        $this->assertEquals(8, $date->month);
        $this->assertEquals(2, $date->day);
        $this->assertEquals(0, $date->hour);
        $this->assertEquals(0, $date->minute);
        $this->assertEquals(0, $date->second);
    }

    public function test20210805_000000()
    {
        // init
        $deadline = new NextMonthFirstBusinessDay(2021, 7, 20);

        // set first days
        $deadline->setFirstDayOfMonth(5);

        // get deadline
        $date = $deadline();
        $this->assertEquals(2021, $date->year);
        $this->assertEquals(8, $date->month);
        $this->assertEquals(5, $date->day);
        $this->assertEquals(0, $date->hour);
        $this->assertEquals(0, $date->minute);
        $this->assertEquals(0, $date->second);
    }

    public function test20210809_000000()
    {
        // init
        $deadline = new NextMonthFirstBusinessDay(2021, 7, 20);

        // set first days
        $deadline->setFirstDayOfMonth(7);

        // get deadline
        $date = $deadline();
        $this->assertEquals(2021, $date->year);
        $this->assertEquals(8, $date->month);
        $this->assertEquals(9, $date->day);
        $this->assertEquals(0, $date->hour);
        $this->assertEquals(0, $date->minute);
        $this->assertEquals(0, $date->second);
    }

    public function test20210901_000000()
    {
        // init
        $deadline = new NextMonthFirstBusinessDay(2021, 8, 31);

        // get deadline
        $date = $deadline();
        $this->assertEquals(2021, $date->year);
        $this->assertEquals(9, $date->month);
        $this->assertEquals(1, $date->day);
        $this->assertEquals(0, $date->hour);
        $this->assertEquals(0, $date->minute);
        $this->assertEquals(0, $date->second);
    }
}
