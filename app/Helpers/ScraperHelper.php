<?php

namespace App\Helpers;


class ScraperHelper
{
    function getFinalResponse( $url, $timeout = 5 )
    {
        $url = str_replace( "&amp;", "&", urldecode(trim($url)) );

        $cookie = tempnam ("/tmp", "CURLCOOKIE");
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1" );
        curl_setopt( $ch, CURLOPT_URL, $url );
        curl_setopt( $ch, CURLOPT_COOKIEJAR, $cookie );
        curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
        curl_setopt( $ch, CURLOPT_ENCODING, "" );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch, CURLOPT_AUTOREFERER, true );
        curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, $timeout );
        curl_setopt( $ch, CURLOPT_TIMEOUT, $timeout );
        curl_setopt( $ch, CURLOPT_MAXREDIRS, 10 );
        $content = curl_exec( $ch );
        $response = curl_getinfo( $ch );
        curl_close ( $ch );

        $c["url"] = $response['url'];
        $c["content"] = $content;

        if ($response['http_code'] == 301 || $response['http_code'] == 302)
        {
            ini_set("user_agent", "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1");
            $headers = get_headers($response['url']);

            $location = "";
            foreach( $headers as $value )
            {
                if ( substr( strtolower($value), 0, 9 ) == "location:" )
                    return $this->getFinalResponse(trim(substr($value, 9, strlen($value))));
            }
        }

        if (    preg_match("/window\.location\.replace\('(.*)'\)/i", $content, $value) ||
            preg_match("/window\.location\=\"(.*)\"/i", $content, $value)
        )
        {
            return $this->getFinalResponse( $value[1] );
        }
        else
        {
            return $c;
        }
    }

    function isHtml($string)
    {
        if ( $string != strip_tags($string) )
        {
            return true; // Contains HTML
        }
        return false; // Does not contain HTML
    }

    public function processHtml($html, $tags) {
        $dom = new \DOMDocument('1.0', 'UTF-8');
        // set error level
        $internalErrors = libxml_use_internal_errors(true);

        // load HTML
        $dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));

        foreach ($dom->getElementsByTagName('a') as $item) {
            $item->setAttribute('href', 'javascript:void(0);');
        }
        $remove = [];
        foreach ($tags as $tag) {
            $script = $dom->getElementsByTagName($tag);
            foreach($script as $item)
            {
                $remove[] = $item;
            }
        }
        foreach ($remove as $item)
        {
            $item->parentNode->removeChild($item);
        }
        $html = $dom->saveHTML();
        libxml_use_internal_errors($internalErrors);
        return $html;
    }


}