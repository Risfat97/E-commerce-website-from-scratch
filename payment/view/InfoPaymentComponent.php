<?php
    namespace App\payment\view;

    class InfoPaymentComponent{
        public static function render(){
            return <<<HTML
                <div class="container">
                    <div class="row">
                        <h1 class="col-12 text-center my-2">Commande validée </h1>
                        <a href="index.php" class="btn btn-primary">Retour à l'accueil</h6>
                    </div>
                </div>
HTML;
        }
    }
?>