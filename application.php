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



use \DateTime as DateTime;
use SBG\App\Helper\Minute;
use SBG\App\Model\FetcherSelector;
use SBG\App\Model\GoogleFetcher;
use SBG\App\Model\RestFetcher;

require_once 'vendor/autoload.php';


if (!isset($argv[1])) {
    echo "give one arg\n";
    return;
}


$dt = new DateTime();
$texturalDt = $dt->format("Y-m-d H:i:s");
$fs = new FetcherSelector(new Minute($dt));

$fs->registerFetcher(new GoogleFetcher())
    ->registerFetcher(new GoogleFetcher())
    ->registerFetcher(new RestFetcher());

$fetcher = $fs->getFetcher();
$fetcherName = get_class($fetcher);

$results = $fetcher->get($argv[1]);

foreach ($results as $r) {
    echo "#####################################################\n";
    $msg = sprintf("%s - %s got result: %s\n",
        $texturalDt,
        $fetcherName,
        $r->getPayload()
    );
    echo $msg;
}


