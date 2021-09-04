<?php
    namespace App\historyDetails\view;

    class HistoryDetailComponent{

        public static function render(){
            $detailHistory = '';
            return <<<HTML
                <div class="col-12 history-container">
                    <div class="row">
                        <div class="col-12 d-flex justify-content-center">
                            <h3 class="mt-3 mb-4">Details historique des commandes</h3>
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
    }
?>