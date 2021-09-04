<?php
    namespace App\history\model;

    use App\services as srv;

    class DatabaseHistoryRepository{
        private $dbService;

        public function __construct(){
            $this->dbService = srv\DatabaseService::getInstance();
        }

        public function getOrderHistory($email){            
            $query = 'select date_com, C.Uemail, SUM(LC.quantite * I.prix) as prixTotal from utilisateur U, articles I, commandes C, ligne_commande LC where C.id = LC.id_com and C.Uemail = U.Uemail and LC.id_item = I.id and C.Uemail = :email group by date_com order by date_com DESC';
            $req = $this->dbService->prepare($query);
            $req->execute(['email' => $email]);
            return $req->fetchAll();
        }
    }
?>