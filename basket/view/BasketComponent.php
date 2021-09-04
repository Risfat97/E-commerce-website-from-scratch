<?php
    namespace App\basket\view;

    class BasketComponent{
        
        public static function render($items){
            $overviewBasket = self::overviewBasketComponent($items);
            $orderSummary = self::orderSummaryComponent($items);
            return <<<HTML
                <div class="col-12 basket-container">
                    <div class="row">
                        <div class="col-12 d-flex justify-content-center">
                            <h3 class="mt-3 mb-4">Panier</h3>
                        </div>
                        <div class="container">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-7 mx-3">
                                        $overviewBasket
                                    </div>
                                    <div class="col-4">
                                        $orderSummary
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
HTML;
        }

        private static function emptyBasketComponent(){
            return <<<HTML
                <div class="row">
                    <div class="card col-12">
                        <div class="card-body">
                            <h6>Votre panier ne comporte aucun article.</h6>
                            <p><a href="index.php" class="text-dark">Retour à la liste d'articles</a></p>
                        </div>
                    </div>
                </div>
HTML;
        }

        private static function overviewBasketComponent($items){
            if(empty($items))
                return self::emptyBasketComponent();
            $overview = '';
            foreach($items as $item){
                $name = $item->getName();
                $category = $item->getCategory();
                $url = $item->getImage();
                $quantity = $item->getQuantity();
                $price = $item->getPrice();
                $tmp = <<<HTML
                    <div class="row item-container-basket">
                        <div class="card col-2 p-0 mr-1">
                            <img class="card-img-top" src="$url" alt="Image article">
                        </div>
                        <div class="col-8">
                            <div class="row">
                                <h5 class="col-12 card-title m-0">$name</h5>
                                <p class="col-12 card-text text-muted m-0">$category</p>
                                <p class="col-12 card-text text-muted m-0">Quantité: $quantity</p>
                                <p class="col-12 card-text m-0 mb-2">$price €</p>
                            </div>
                        </div>
                        <div class="col-1 p-0">
                            <button type="button" class="btn remove-item m-0" title="supprimer du panier"><i class="far fa-trash-alt"></i></button>
                        </div>
                    </div>
                    <hr class="bg-dark w-100">
HTML;
                $overview = $overview . $tmp;
            }
            return $overview;
        }

        private static function orderSummaryComponent($items){
            $totalPrice = self::getTotalPrice($items);
            $totalOrder = $totalPrice + 3.99;
            return <<<HTML
                <div class="row bg-white p-2">
                    <div class="col-12 d-flex justify-content-center">
                        <h5>Finaliser commande</h5>
                    </div>
                    <div class="col-12 d-flex justify-content-between">
                        <p>Valeur de la commande</p>
                        <p>$totalPrice €</p>
                    </div>
                    <div class="col-12 d-flex justify-content-between">
                        <p>Livraison</p>
                        <p>3.99 €</p>
                    </div>
                    <hr class="bg-dark w-100">
                    <div class="col-12 d-flex justify-content-between">
                        <h5>Total</h5>
                        <h5>$totalOrder €</h5>
                    </div>
                    <div class="col-12 card bg-dark p-0">
                        <a href="payer.php" class="text-white"><h5 class="card-title text-center text-white mt-1">Payer</h5></a>
                    </div>
                </div>
HTML;
        }

        private static function getTotalPrice($items){
            $totalPrice = 0;
            foreach($items as $item){
                $totalPrice += $item->getQuantity() * $item->getPrice();
            }
            return $totalPrice;
        }
    }
?>