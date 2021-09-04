<?php
    namespace App\basket\controller;

    use App\basket\model as mdl1;
    use App\item\model as mdl;
    use App\basket\view as vw;

    class BasketController{
        private $basketRepo;

        public function __construct(mdl1\BasketRepository $basketRepo){
            $this->basketRepo = $basketRepo;
        }

        public function showBasket(){
            $items = $this->basketRepo->getItems();
            return vw\BasketComponent::render($items);
        }

        public function addAction(){
            $status = 'error';
            if($this->checkFields()){
                $name = htmlspecialchars($_POST['name']);
                $category = htmlspecialchars($_POST['category']);
                $url = htmlspecialchars( $_POST['url']);
                $quantite = intval($_POST['quantity']);
                $price = floatval($_POST['price']);
                $itemToAdd = new mdl\Item($name, $category, $url, $quantite, $price);
                $this->basketRepo->addItem($itemToAdd);
                $status = 'success';
            }
            echo $status;  
        }

        public function removeAction(){
            $status = 'error';
            if($this->checkFields()){
                $name = htmlspecialchars($_POST['name']);
                $category = htmlspecialchars($_POST['category']);
                $url = htmlspecialchars( $_POST['url']);
                $quantite = intval($_POST['quantity']);
                $price = floatval($_POST['price']);
                $itemToRemove = new mdl\Item($name, $category, $url, $quantite, $price);
                $this->basketRepo->removeItem($itemToRemove);
                $status = 'success';
            }
            echo $status; 
        }

        private function checkFields(){
            return isset($_POST['name'], $_POST['category'], $_POST['url'], $_POST['price'], $_POST['quantity']) &&
                $_POST['name'] !== '' &&
                $_POST['category'] !== '' &&
                $_POST['url'] !== '' &&
                $_POST['price'] !== '' &&
                $_POST['quantity'] != 0;
        }
    }
?>