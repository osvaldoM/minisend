<?php // Code within app\Helpers\Helper.php

namespace App\Helpers;

class Helper
{
    public static function shout(string $string)
    {
        return strtoupper($string);
    }

    public static function removeUnwantedTags($html)
    {

//        return $html;
        $dom = new \DOMDocument();

        $dom->loadHTML($html);

        $tags_to_remove = array('script','style','iframe','link');

        foreach($tags_to_remove as $tag){
            $elements = $dom->getElementsByTagName($tag);
            foreach($elements as $item){
                $item->parentNode->removeChild($item);
            }
        }
        return trim($dom->saveHTML());

    }
}
