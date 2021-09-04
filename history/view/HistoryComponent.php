<?php
    namespace App\history\view;

    class HistoryComponent{

        public static function render($orders){
            $overviewHistory = self::overviewHistoryComponent($orders);
            return <<<HTML
                <div class="col-12 history-container">
                    <div class="row">
                        <div class="col-12 d-flex justify-content-center">
                            <h3 class="mt-3 mb-4">Historique des commandes</h3>
                        </div>
                        <div class="container">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-8 offset-2">
                                        $overviewHistory
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
HTML;
        }

        private static function emptyHistoryComponent(){
            return <<<HTML
                <div class="row">
                    <div class="card col-12">
                        <div class="card-body">
                            <h6>Vous n'avez fait aucune commande.</h6>
                            <p><a href="index.php" class="text-dark">Retour à la liste d'articles</a></p>
                        </div>
                    </div>
                </div>
HTML;
        }

        private static function overviewHistoryComponent($orders){
            if(empty($orders))
                return self::emptyHistoryComponent();
            $overview = '';
            foreach($orders as $order){
                $date = $order['date_com'];
                $prixTotal = $order['prixTotal'] + 3.99;
                $tmp = <<<HTML
                    <div class="row item-container-history">
                        <div class="col-12">
                            <div class="row card bg-white">
                                <div class="col-12 d-flex justify-content-end">
                                    <p class="text-muted">$date</p>
                                </div>
                                <div class="col-12 d-flex justify-content-between p-2">
                                    <h5 class="card-title">Valeur de la commande: $prixTotal €</h5>
                                    <div>
                                        <a href="#" class="btn btn-primary" title="Pas encore implémenté">Voir détails</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="bg-dark w-100">
HTML;
                $overview = $overview . $tmp;
            }
            return $overview;
        }
    }
?>