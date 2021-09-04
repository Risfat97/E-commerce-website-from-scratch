<?php
    namespace App\services;

    class SessionService{
        private static $instance = null;

        private function __construct(){
            session_start();
        }

        public function get($key){
            return  $_SESSION[$key];
        }

        public function set($key, $value){
            $_SESSION[$key] = $value;
        }

        public function exists($key): bool{
            return isset($_SESSION[$key]);
        }

        public function delete($key){
            unset($_SESSION[$key]);
        }

        public static function getInstance(){
            if(is_null(self::$instance))
                self::$instance = new SessionService();
            return self::$instance;
        }
    }
?>