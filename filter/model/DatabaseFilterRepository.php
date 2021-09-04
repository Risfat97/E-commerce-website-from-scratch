<?php
    namespace App\filter\model;
    use App\services as srv;

    class DatabaseFilterRepository implements FilterRepository{
        private $dbService;

        public function __construct(){
            try{
                $this->dbService = srv\DatabaseService::getInstance();
            } catch(\Exception $e){
                throw new \Exception($e->getMessage());
            }
        }

        public function getCategory(){
            $req = $this->dbService->query('select categorie, count(*) as nombre from articles group by categorie');
            return $req->fetchAll();
        }
    }
?>