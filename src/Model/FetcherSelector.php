<?php
/**
 * Created by PhpStorm.
 * User: aaugustyniak
 * Date: 14.05.17
 * Time: 15:15
 */

namespace SBG\App\Model;


use SBG\App\Helper\Minute;
use \DateTime as DateTime;

class FetcherSelector
{

    /**
     * @var DateTime
     */
    private $minute;


    private $fetchers = [];


    /**
     * FetcherSelector constructor.
     * @param Minute $m
     */
    public function __construct(Minute $m)
    {
        $this->minute = $m;
    }

    /**
     * @param WebFetcher $f
     * @return $this
     */
    public function registerFetcher(WebFetcher $f)
    {
        $this->fetchers[] = $f;
        return $this;
    }

    /**
     * @return WebFetcher
     */
    public function getFetcher()
    {

        foreach ($this->fetchers as $f) {
            if ($this->minute->isOdd() && $f instanceof GoogleFetcher) {
                return $f;
            }
            if ($this->minute->isEven() && $f instanceof RestFetcher) {
                return $f;
            }
        }

        return null;
    }


}