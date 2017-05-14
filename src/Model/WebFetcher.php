<?php
/**
 * Created by PhpStorm.
 * User: aaugustyniak
 * Date: 14.05.17
 * Time: 13:18
 */

namespace SBG\App\Model;


use SBG\App\Entity\WebResult;

interface WebFetcher
{

    /**
     * @param $param string
     * @return WebResult[]
     */
    public function get($param);


}