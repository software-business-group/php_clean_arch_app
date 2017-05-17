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

namespace SBG\App\Model;


use SBG\App\Entity\Result;
use function SimpleHtmlDom\file_get_html;

class GoogleFetcher extends DataFetcher
{

    /**
     * @param $param string
     * @return Result[]
     */
    public function fetch($param)
    {
        if ($this->strategy->useGoogle()) {
            return $this->fetchDataImpl($param);
        } else {
            return $this->nextFetcher->fetch($param);
        }
    }

    /**
     * @param $param
     * @return array
     */
    private function fetchDataImpl($param)
    {
        $results = [];
        try {
            $in = $param;
            $in = str_replace(' ', '+', $in); // space is a +
            $url = 'http://www.google.com/search?hl=en&tbo=d&site=&source=hp&q=' . $in . '&oq=' . $in . '';
            $html = file_get_html($url);
            $results = $this->tmpSolutionForRefactor($html, $results);
        } catch (\Exception $e) {
            print $e;
        }
        return $results;
    }

    /**
     * @param $html
     * @param $results
     * @return array
     */
    private function tmpSolutionForRefactor($html, $results)
    {
        $i = 0;
        $linkObjs = $html->find('h3.r a');
        $matches = null;
        foreach ($linkObjs as $linkObj) {
            $title = trim($linkObj->plaintext);
            $link = trim($linkObj->href);

            // if it is not a direct link but url reference found inside it, then extract
            if (!preg_match('/^https?/', $link) && preg_match('/q=(.+)&amp;sa=/U', $link, $matches) && preg_match('/^https?/', $matches[1])) {
                $link = $matches[1];
            } else if (!preg_match('/^https?/', $link)) { // skip if it is not a valid link
                continue;
            }

            $descr = $html->find('span.st', $i); // description is not a child element of H3 thereforce we use a counter and recheck.
            $i++;
            $webResult = new Result();
            $webResult->setPayload($title);
            $results[] = $webResult;


        }
        return $results;
    }
}