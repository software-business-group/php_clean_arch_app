<?php
/**
 * Created by PhpStorm.
 * User: aaugustyniak
 * Date: 14.05.17
 * Time: 13:21
 */

namespace SBG\App\Model;


use SBG\App\Entity\WebResult;

class RestFetcher implements WebFetcher
{

    /**
     * @param $param string
     * @return WebResult[]
     */
    public function get($param)
    {
        $results = [];
        try {

            $api = new \OtherCode\Rest\Rest(new \OtherCode\Rest\Core\Configuration(array(
                'url' => 'http://jsonplaceholder.typicode.com/',
                'httpheader' => array(
                    'some_header' => 'some_value',
                )
            )));
            $api->setDecoder("json");

            //$query = urlencode("sunt aut facere repellat provident occaecati excepturi optio reprehenderit");
            $queryString = sprintf("posts");

            $response = $api->get($queryString);
            foreach ($response->body as $e) {
                $webResult = new WebResult();
                $webResult->setPayload($e->body);
                $results[] = $webResult;
            }


        } catch (\Exception $e) {
            print "> " . $e->getMessage() . "\n";
        }


        return $results;
    }
}