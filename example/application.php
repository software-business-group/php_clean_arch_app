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


use \DateTime as DateTime;
use SBG\App\Helper\MinuteStrategy;
use SBG\App\Model\GoogleFetcher;
use SBG\App\Model\RestFetcher;

require_once '../vendor/autoload.php';


if (!isset($argv[1])) {
    echo "usage php ./app.php <search term>\n";
    return 1;
}


$searchTerm = (string)$argv[1];
$now = new DateTime();
$texturalNow = $now->format("Y-m-d H:i:s");
$selectionStrategy = new MinuteStrategy($now);

$fetcherChain = new GoogleFetcher($selectionStrategy);
$fetcherChain->setNextFetcher(new RestFetcher($selectionStrategy));


$results = $fetcherChain->fetch($searchTerm);


foreach ($results as $r) {
    echo "#####################################################\n";

    $msg = sprintf("%s got result: %s\n",
        $texturalNow,
        $r->getPayload()
    );
    echo $msg;
}


