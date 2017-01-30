<?php

    namespace Knowledgebase;

    class SmartyWrapper{
    
        protected static $engine; 

        static function init(){
            self::$engine = new \Smarty;
            self::$engine->caching = false;
        }

        static function fetch($templateFile){
            return self::$engine->fetch($templateFile);
        }

        static function assign($key, $value){
            self::$engine->assign($key, $value);
        }

    }

?>
