<?php

    namespace Knowledgebase;

    class SmartyWrapper{
    
        protected static $engine; 

        static function init(){
            self::$engine = new \Smarty;
            self::$engine->registerPlugin("modifier",'base64_encode',  'base64_encode');
            self::$engine->caching = false;
        }

        static function fetch($templateFile){
            return self::$engine->fetch($templateFile);
        }

        static function display($templateFile){
            return self::$engine->display($templateFile);
        }

        static function assign($key, $value){
            self::$engine->assign($key, $value);
        }

        static function clearAll(){
            self::$engine->clearAllAssign();
        }

        static function adminAccess(){
            $ipList = ['60.230.186.248','149.135.111.80','::1', '127.0.0.1'];
            return in_array($_SERVER['REMOTE_ADDR'],$ipList) && !isset($_REQUEST['preview']);
        }

    }

?>
