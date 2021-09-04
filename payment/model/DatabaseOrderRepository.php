<?php
    namespace App\payment\model;

    use App\services as srv;
    use App\basket\model as mdl;
    use App\user\classes as cls;

    class DatabaseOrderRepository{
        private $dbService;
        private $basket;
        
        public function __construct(){
            $this->dbService = srv\DatabaseService::getInstance();
            $this->basket = new mdl\BasketRepository();
        }

        public function isEmptyBasket(){
            return $this->basket->isEmpty();
        }

        public function emptyBasket(){
            $this->basket->clean();
        }
        
        public function saveOrder(){
            $authService = new srv\AuthService();
            $userdata = $authService->getUserData();
            $items = $this->basket->getItems();
            $order = new Order($userdata->getEmail());
            $query = 'insert into commandes(Uemail, date_com) values (:email, :date)';
            $options = [
                'email' => $order->getIdClient(),
                'date' => $order->getDate()
            ];
            $this->queryInsert($query, $options);
            $idCom = $this->getNumCommande($order->getDate());
            $this->insertOrder($items, $idCom);
        }

        private function getNumCommande($date){
            $query = 'select id from commandes where date_com = :date';
            $options = ['date' => $date];
            $req = $this->dbService->prepare($query);
            $req->execute($options);
            return $req->fetch()[0];
        }

        private function getIdItem($url){
            $newUrl = str_replace('assets/items/', '', $url);
            $query = 'select id from articles where image = :url';
            $options = ['url' => $newUrl];
            $req = $this->dbService->prepare($query);
            $req->execute($options);
            return $req->fetch()[0];
        }

        private function insertOrder($items, $id_com){
            foreach($items as $item){
                $query = 'insert into ligne_commande(id_com, id_item, quantite) values (:idCom, :idItem, :quantite)';
                $options = [
                    'idCom' => $id_com,
                    'idItem' => $this->getIdItem($item->getImage()),
                    'quantite' => $item->getQuantity()
                ];
                $this->queryInsert($query, $options);
            }
        }

        private function queryInsert($query, $options){
            $req = $this->dbService->prepare($query);
            $req->execute($options);
        }
        
    }
?>