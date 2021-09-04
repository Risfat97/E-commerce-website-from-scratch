<?php
    namespace App\services;

    class DatabaseService{
        private static $instance = null;
        private $bdd = null;

        private function __construct(){
            try{
                $this->bdd = new \PDO("mysql:host=localhost;dbname=bdd_ecommerce;charset=utf8", 
                    'user',
                    'root',
                    [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]
                );
            } catch(\Exception $e){
                throw new \Exception($e->getMessage());
            }
        }

        public static function getInstance(){
            if(is_null(self::$instance)){
                try{
                    self::$instance = new DatabaseService();
                } catch(\Exception $e){
                    throw new \Exception($e->getMessage());
                }
            }
            return self::$instance->bdd;
        }
    }
?>