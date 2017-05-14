<?php

namespace SBG\App\Entity;


class WebResult
{

    /**
     * @var string
     */
    private $payload;

    /**
     * @return string
     */
    public function getPayload()
    {
        return $this->payload;
    }

    /**
     * @param string $payload
     */
    public function setPayload($payload)
    {
        $this->payload = $payload;
    }


}