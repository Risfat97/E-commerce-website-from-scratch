<?php
    namespace App\item\view;

    use App\services as srv;

    class ItemComponent{
        public static function render($item){
            $btn = '';
            $authService = new srv\AuthService();
            $user = $authService->getUserData();
            if (is_null($user) || (!is_null($user) && !$user->isAdmin()))
            {
                $btn = self::addToBasket();
            }
            else if (!is_null($user))
            {  
                $btn = self::deleteFromRepo(); 
            }
            $url = 'assets/items/' . $item['image'];
            $name = $item['nom'];
            $category = $item['categorie'];
            $price = $item['prix'];
            return <<<HTML
                <div class="col-3 card p-0 mb-1 item-container">
                    <img class="card-img-top" src="$url" alt="Image article">
                    <div class="card-body">
                        <h5 class="card-title m-0">$name</h5>
                        <p class="card-text text-muted m-0">$category</p>
                        <p class="card-text m-0 mb-2">$price €</p>
                        $btn
                    </div>
                </div>
HTML;
        }

        private static function addToBasket()
        {
            return <<<HTML
            <div class="add-item-container d-flex justify-content-center">
                        <button type="button" class="btn btn-primary add-to-basket"><i class="fas fa-shopping-bag"></i> Ajouter </button>
                        <p class="item-added text-center bg-dark text-white px-3">Article ajouté au panier</p>
            </div>
HTML;
        }

        private static function deleteFromRepo()
        {
            return <<<HTML
            <div class="add-item-container d-flex justify-content-center">
                    <button type="button" class="btn btn-primary del-from-repo"><i class="fas fa-shopping-bag"></i> Supprimer </button>
                    <p class="item-added text-center bg-dark text-white px-3">Article Supprimé</p>
            </div>
HTML;
        }
    }
?>