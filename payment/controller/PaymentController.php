<?php
    namespace App\payment\controller;

    use App\payment\model as mdl;
    use App\payment\view as vw;
    use App\services as srv;

    class PaymentController{
        private $dbOrderRepository;
        private $authService;

        public function __construct($dbOrderRepository){
            $this->authService = new srv\AuthService();
            $this->dbOrderRepository = $dbOrderRepository;
        }

        public function action(){
            $zeroError = true;
            $errors = [
                'err-titulaire' => '',
                'err-num-card' => '',
                'err-other' => ''
            ];
            if(!$this->authService->isUserConnected()){
                $this->goToLoginPage();
            } else{
                if($this->checkFormFieldsComplete()){
                    $titulaire = \htmlspecialchars($_POST['titulaire']);
                    $numero = \htmlspecialchars($_POST['numero-carte']);
                    $mois = \htmlspecialchars($_POST['month']);
                    $year = \htmlspecialchars($_POST['year']);
                    $cvv = \htmlspecialchars($_POST['cvv']);

                    if(\strlen($numero) !== 16){
                        $errors['err-num-card'] = '<p class="text-danger error">Numéro doit contenir 16 chiffres</p>';
                        $zeroError = false;
                    }

                    if(\intval($mois) < 1 || \intval($mois) > 12){
                        $errors['err-other'] = '<p class="text-danger error">Mois incorrect</p>';
                        $zeroError = false;
                    } elseif(\intval($year) < \intval(date('Y'))){
                        $errors['err-other'] = '<p class="text-danger error">Année incorrecte</p>';
                        $zeroError = false;
                    } elseif(\strlen($cvv) !== 3){
                        $errors['err-other'] = '<p class="text-danger error">Le numéro CVV doit contenir 3 chiffres</p>';
                        $zeroError = false;
                    }

                    if($zeroError){
                        try{
                            $this->dbOrderRepository->saveOrder();
                        } catch(\Exception $e){
                            return $e->getMessage();
                        }
                        
                        $this->dbOrderRepository->emptyBasket();
                        $this->goToItems();
                    }
                }
            }
            return vw\PaymentComponent::render($errors);
        }

        private function goToItems(){
            header('Location: index.php');
            die();
        }

        private function goToLoginPage(){
            header('Location: login.php');
            die();
        }

        private function goToBasket(){
            header('Location: basket.php');
            die();
        }

        private function checkFormFieldsComplete(){
            return isset($_POST['titulaire'], $_POST['numero-carte'], $_POST['month'], $_POST['year'], $_POST['cvv']) &&
                $_POST['titulaire'] !== '' &&
                $_POST['numero-carte'] !== '' &&
                $_POST['month'] !== '' &&
                $_POST['year'] !== '' &&
                $_POST['cvv'] !== '';
        }
    }
?>