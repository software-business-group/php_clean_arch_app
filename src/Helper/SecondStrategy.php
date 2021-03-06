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

namespace SBG\App\Helper;

use \DateTime as DateTime;

class SecondStrategy implements BinaryStrategy
{

    /**
     * @var DateTime
     */
    private $time;

    /**
     * SecondStrategy constructor.
     * @param DateTime $time
     */
    public function __construct(DateTime $time)
    {
        $this->time = $time;
    }


    /**
     * Returns true if second is odd
     * @return bool
     */
    public function useGoogle()
    {
        return $this->isOdd();
    }


    /**
     * Returns true if second is even
     * @return bool
     */
    public function useRest()
    {
        return !$this->useGoogle();
    }

    private function isOdd()
    {
        $seconds = intval($this->time->format("s"));
        return (bool)($seconds % 2);
    }
}