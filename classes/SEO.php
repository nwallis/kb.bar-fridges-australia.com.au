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

    static function deleteSEOName($nodeID){
        try{
            unset(self::$seoMap->{self::$seoMap->{$nodeID}});
            unset(self::$seoMap->{$nodeID});
            self::updateMap();
        } catch (Exception $e) {
        }
    }

    static function updateMap(){
        file_put_contents("./seo.map", json_encode(self::$seoMap));
    }

    static function addSEOName($nodeID, $seoName){
        $duplicateCount=0;
        $originalSEOName = $seoName;
        while (key_exists($seoName, self::$seoMap)){
            $duplicateCount++;
            $seoName = $originalSEOName . "-" . $duplicateCount;
        }

        self::$seoMap->{$seoName} = $nodeID;
        self::$seoMap->{$nodeID} = $seoName;
        self::updateMap();
    }

    static function updateSEOName($nodeID, $seoName){
        $oldSEOName = self::$seoMap->{$nodeID};
        unset(self::$seoMap->{$nodeID});
        unset(self::$seoMap->{$oldSEOName});
        self::addSEOName($nodeID,  $seoName);
    }

    static function GUID()
    {
        if (function_exists('com_create_guid') === true) return trim(com_create_guid(), '{}');
        return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }

}

?>
