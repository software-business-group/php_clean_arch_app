<?php
/*
 * The MIT License (MIT)
 *
 * Copyright (c) 2017 SBG
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
use SBG\App\Model\FetcherSelector;


/**
 * @author Artur Augustyniak <artur@aaugustyniak.pl>
 */
class FetcherSelectorTest extends TestCase
{


    const MOCK_ODD = true;
    const MOCK_EVEN = false;


    const MOCK_REST_FETCHER = 'SBG\App\Model\RestFetcher';
    const MOCK_GOOGLE_FETCHER = 'SBG\App\Model\GoogleFetcher';


    /**
     * @test
     */
    public function selector_should_return_null_if_no_fetcher_was_registred()
    {

        $minute = $this->createPassiveMinuteMock();
        $fs = new FetcherSelector($minute);
        $actual = $fs->getFetcher();
        $this->assertNull($actual);
    }

    /**
     * @test
     */
    public function selector_should_return_instance_of_some_web_fetcher()
    {
        $minute = $this->createPassiveMinuteMock();
        $fs = new FetcherSelector($minute);
        $fetcherMock = $this->createFetcherMock(self::MOCK_GOOGLE_FETCHER);
        $fs->registerFetcher($fetcherMock);
        $actual = $fs->getFetcher();
        $expected = 'SBG\App\Model\WebFetcher';
        $this->assertInstanceOf($expected, $actual);
    }


    /**
     * @test
     */
    public function selector_should_return_instance_of_google_fetcher_if_minute_is_odd()
    {
        $minute = $this->createMinuteMock(self::MOCK_ODD);
        $fs = new FetcherSelector($minute);
        $fs->registerFetcher(
            $this->createFetcherMock(
                self::MOCK_REST_FETCHER)
        )->registerFetcher(
            $this->createFetcherMock(
                self::MOCK_GOOGLE_FETCHER)
        );


        $actual = $fs->getFetcher();
        $expected = 'SBG\App\Model\GoogleFetcher';
        $this->assertInstanceOf($expected, $actual);

    }


    /**
     * @test
     */
    public function selector_should_return_instance_of_rest_fetcher_if_minute_is_even()
    {

        $minute = $this->createMinuteMock(self::MOCK_EVEN);
        $fs = new FetcherSelector($minute);
        $fs->registerFetcher(
            $this->createFetcherMock(
                self::MOCK_GOOGLE_FETCHER)
        )
            ->registerFetcher(
                $this->createFetcherMock(
                    self::MOCK_REST_FETCHER)
            );
        $actual = $fs->getFetcher();
        $expected = 'SBG\App\Model\RestFetcher';
        $this->assertInstanceOf($expected, $actual);

    }

    /**
     * @return m\MockInterface
     */
    private function createPassiveMinuteMock()
    {
        return $this->createMinuteMock(self::MOCK_ODD);
    }

    /**
     * @param boolean $isOdd
     * @return m\MockInterface
     */
    private function createMinuteMock($isOdd)
    {
        $methods = array('isOdd' => $isOdd, 'isEven' => !$isOdd);
        $mock = m::mock('SBG\App\Helper\Minute', $methods);
        return $mock;
    }


    /**
     * @param $fetcherClass
     * @return m\MockInterface
     */
    private function createFetcherMock($fetcherClass)
    {
        $mock = m::mock($fetcherClass);
        return $mock;
    }


}
