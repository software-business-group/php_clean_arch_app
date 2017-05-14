<?php
/**
 * Created by PhpStorm.
 * User: aaugustyniak
 * Date: 14.05.17
 * Time: 14:02
 */

namespace SBG\App\Model;


use SBG\App\Entity\WebResult;

class GoogleFetcher implements WebFetcher
{

    /**
     * @param $param string
     * @return WebResult[]
     */
    public function get($param)
    {
        $results = [];
        try {
            $in = $param;
            $in = str_replace(' ', '+', $in); // space is a +
            $url = 'http://www.google.com/search?hl=en&tbo=d&site=&source=hp&q=' . $in . '&oq=' . $in . '';
            $html = \SimpleHtmlDom\file_get_html($url);

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
            $webResult = new WebResult();
            $webResult->setPayload($title);
            $results[] = $webResult;


        }
        return $results;
    }
}