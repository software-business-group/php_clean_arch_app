<?php
/**
 * Created by PhpStorm.
 * User: aaugustyniak
 * Date: 14.05.17
 * Time: 14:17
 */

namespace SBG\App\Model;


use SBG\App\Entity\WebResult;

class FakeFetcher implements WebFetcher
{

    /**
     * @param $param string
     * @return WebResult[]
     */
    public function get($param)
    {

        $a = new WebResult();
        $a->setPayload("dupa");

        $b = new WebResult();
        $b->setPayload("cyce");

        return [$a, $b];
    }
}