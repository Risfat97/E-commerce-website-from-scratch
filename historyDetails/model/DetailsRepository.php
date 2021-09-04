<?php
    namespace App\historyDetails\model;

    interface DetailsRepository{

        public function getItems($orderId);
    }
?>