<?php
    namespace App\historyDetails\model;

    use App\services as srv;
    use App\item\model;

    class DatabaseDetailsRepository implements DetailsRepository{
        private $dbService;

        public function __construct(srv\DatabaseService $dbService){
            $this->dbService = $dbService;
        }

        public function getItems($orderId){
            $items = [];
            $query = "select *";
            return $items;
        }
    }
?>