<?php

namespace Knowledgebase;

class SEO {

    protected static $seoMap;

    static function init(){
        self::$seoMap = json_decode(file_get_contents('./seo.map'));
    }

    static function getMapping($mapID){
        return isset(self::$seoMap->{$mapID}) ? self::$seoMap->{$mapID} : "";
    } 

    static function addSEOName($nodeID, $seoName){
        self::$seoMap->{$seoName} = $nodeID;
        self::$seoMap->{$nodeID} = $seoName;
        file_put_contents("./seo.map", json_encode(self::$seoMap));
    }

    static function GUID()
    {
        if (function_exists('com_create_guid') === true)
        {
            return trim(com_create_guid(), '{}');
        }

        return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }

}

?>
