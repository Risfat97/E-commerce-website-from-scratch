<?php
    namespace App;

    class Autoloader{
        public static function register(){
            spl_autoload_register([
                __CLASS__,
                'autoload'
            ]);
        }

        public static function autoload($class){
            $class = str_replace(__NAMESPACE__ . '\\', '', $class);
            $class = str_replace('\\', '/', $class);
            if(file_exists($class . '.php'))
                require_once $class . '.php';
            else
                throw new \Exception('No such file or directory ' . $class . '.php');
        }
    }
?>