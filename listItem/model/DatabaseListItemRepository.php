<?php
    namespace App\listItem\model;

    use App\services as srv;

    class DatabaseListItemRepository implements ListItemRepository{
        private $dbService = null;

        public function __construct(){
            try{
                $this->dbService = srv\DatabaseService::getInstance();
            } catch(\Exception $e){
                throw new \Exception($e->getMessage());
            }
        }

        public function getItems($query, $options){
            $req = null;
            if(empty($options))
                $req = $this->dbService->query($query);
            else{
                $req = $this->dbService->prepare($query);
                $req->execute($options);
            }
            return $req->fetchAll();
        }

        public function getItem($query, $option){
            $req = $this->dbService->prepare($query);
            $req->execute($option);
            return $req->fetch();
        }

        public function getNbItems(){
            $res = $this->dbService->query('select count(id) as nombre from articles')->fetch();
            return (int) $res['nombre'];
        }

        public function addItem($query, $options){
            $req = null;
            if(empty($options))
                $req = $this->dbService->query($query);
            else{
                $req = $this->dbService->prepare($query);
                $req->execute($options);
            }
        }

        public function deleteItem($query, $options)
        {
            $req = null;
            if(empty($options))
                $req = $this->dbService->query($query);
            else{
                $req = $this->dbService->prepare($query);
                $req->execute($options);
            }
        }
    }
?>