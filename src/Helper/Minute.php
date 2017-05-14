<?php
/**
 * Created by PhpStorm.
 * User: aaugustyniak
 * Date: 14.05.17
 * Time: 14:35
 */

namespace SBG\App\Helper;

use \DateTime as DateTime;

class Minute
{

    /**
     * @var DateTime
     */
    private $time;

    /**
     * Minute constructor.
     * @param DateTime $time
     */
    public function __construct(DateTime $time)
    {
        $this->time = $time;
    }


    public function isOdd()
    {
        $seconds = intval($this->time->format("s"));
        return (bool)($seconds % 2);
    }


    public function isEven()
    {
        return !$this->isOdd();
    }


}