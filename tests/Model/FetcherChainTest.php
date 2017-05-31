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
use SBG\App\Model\NullFetcher;


class FetcherChainTest extends TestCase
{

    const SEARCH_TERM = "sdfsdf";


    const MOCK_ODD = true;
    const MOCK_EVEN = false;


    const MOCK_REST_FETCHER = 'SBG\App\Model\RestFetcher';
    const MOCK_GOOGLE_FETCHER = 'SBG\App\Model\GoogleFetcher';


    /**
     * @test
     */
    public function null_chain_should_return_an_empty_array()
    {
        $second = $this->createPassiveSecondMock();
        $fs = new NullFetcher($second);
        $actual = $fs->fetch(self::SEARCH_TERM);
        $this->assertEmpty($actual);
    }


    /**
     * @return m\MockInterface
     */
    private function createPassiveSecondMock()
    {
        return $this->createSecondMock(self::MOCK_ODD);
    }

    /**
     * @param boolean $isOdd
     * @return m\MockInterface
     */
    private function createSecondMock($isOdd)
    {
        $methods = array('useGoogle' => $isOdd, 'useRest' => !$isOdd);
        $mock = m::mock('SBG\App\Helper\SecondStrategy', $methods);
        return $mock;
    }


}
