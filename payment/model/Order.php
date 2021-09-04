<?php
    namespace App\payment\model;

    class Order{
        private $idClient;
        private $date;

        public function __construct($idClient){
            $this->idClient = $idClient;
            \date_default_timezone_set('Europe/Paris');
            $this->date = \date('d-m-Y H:i:s');
        }

        public function getIdClient(){
            return $this->idClient;
        }

        public function getDate(){
            return $this->date;
        }
    }
?>