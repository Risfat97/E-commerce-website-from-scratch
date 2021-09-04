<?php
    namespace App\historyDetails\controller;

    use App\services as srv;
    use App\historyDetails\model as mdl;
    use App\historyDetails\view as vw;

    class HistoryDetailController{
        private $authService;
        private $detailsRepo;

        public function __construct(srv\AuthService $authService, mdl\DetailsRepository $detailsRepo){
            $this->authService = $authService;
            $this->detailsRepo = $detailsRepo;
        }

        public function action(){
            if(!$this->authService->isUserConnected()){
                $this->goToLogin();
            }
            $orderId = -1;
            if(isset($_GET['order-id'])){
                $orderId = intval($_GET['order-id']);
            }
            $items = $this->detailsRepo->getItems($orderId);
            return vw\HistoryDetailComponent::render($items);
        }

        private function goToLogin(){
            header("Location: login.php");
            die();
        }
    }
?>