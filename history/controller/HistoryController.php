<?php
    namespace App\history\controller;

    use App\services as srv;
    use App\history\model as mdl;
    use App\history\view as vw;

    class HistoryController{
        private $dbHistoryRepo;
        private $authService;

        public function __construct(mdl\DatabaseHistoryRepository $dbHistoryRepo){
            $this->authService = new srv\AuthService();
            $this->dbHistoryRepo = $dbHistoryRepo;
        }

        public function action(){
            if(!$this->authService->isUserConnected()){
                header('Location: index.php');
                die();
            }
            $uEmail = $this->authService->getUserData()->getEmail();
            $orders = $this->dbHistoryRepo->getOrderHistory($uEmail);
            return vw\HistoryComponent::render($orders);
        }
    }
?>