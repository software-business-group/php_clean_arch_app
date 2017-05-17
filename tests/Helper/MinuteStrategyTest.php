<?php
/*
 * The MIT License (MIT)
 *
 * Copyright (c) 2017 SOFTWARE BUSINESS GROUP SP. Z O.O. <sbg@sbg.com.pl>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

namespace SBG\Tests\App\Helper;


use \Mockery as m;
use \PHPUnit_Framework_TestCase as TestCase;
use \DateTime as DateTime;
use SBG\App\Helper\MinuteStrategy;


class MinuteStrategyTest extends TestCase
{


    /**
     * @test
     */
    public function edge_case_0()
    {
        $oddSecondsDt = new DateTime("2017-01-01 23:12:00");
        $m = new MinuteStrategy($oddSecondsDt);
        $this->assertTrue($m->useRest());
    }


    /**
     * @test
     */
    public function edge_case_1()
    {
        $oddSecondsDt = new DateTime("2017-01-01 23:12:01");
        $m = new MinuteStrategy($oddSecondsDt);
        $this->assertFalse($m->useRest());
        $this->assertTrue($m->useGoogle());
    }

    /**
     * @test
     */
    public function edge_case_60()
    {
        $oddSecondsDt = new DateTime("2017-01-01 23:12:60");
        $m = new MinuteStrategy($oddSecondsDt);
        $this->assertTrue($m->useRest());
        $this->assertFalse($m->useGoogle());
    }


    /**
     * @test
     */
    public function return_true_is_odd_if_given_date_time_has_odd_seconds()
    {
        $oddSecondsDt = new DateTime("2017-01-01 23:12:13");
        $m = new MinuteStrategy($oddSecondsDt);
        $this->assertTrue($m->useGoogle());

    }


    /**
     * @test
     */
    public function return_false_is_odd_if_given_date_time_has_even_seconds()
    {
        $oddSecondsDt = new DateTime("2017-01-01 23:12:12");
        $m = new MinuteStrategy($oddSecondsDt);
        $this->assertFalse($m->useGoogle());

    }


    /**
     * @test
     */
    public function return_true_is_even_if_given_date_time_has_even_seconds()
    {
        $oddSecondsDt = new DateTime("2017-01-01 23:12:04");
        $m = new MinuteStrategy($oddSecondsDt);
        $this->assertTrue($m->useRest());

    }


    /**
     * @test
     */
    public function return_false_is_even_if_given_date_time_has_odd_seconds()
    {
        $oddSecondsDt = new DateTime("2017-01-01 23:12:07");
        $m = new MinuteStrategy($oddSecondsDt);
        $this->assertFalse($m->useRest());

    }


}
