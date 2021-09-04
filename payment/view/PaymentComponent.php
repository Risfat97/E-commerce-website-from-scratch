<?php
    namespace App\payment\view;

    class PaymentComponent{
        public static function render($errors){
            $errTitulaire = $errors['err-titulaire'];
            $errNumber = $errors['err-num-card'];
            $errOther = $errors['err-other'];
            $months = self::monthSelectComponent();
            $years = self::yearSelectComponent();
            return <<<HTML
                <div class="container">
                    <div class="row">
                        <h1 class="col-12 text-center my-2">Paiement</h1>
                        <div class="col-12 d-flex justify-content-center">
                                <form action="" method="post">
                                    <div class="card payment-card bg-primary p-3">
                                        <div class="row">
                                            <div class="col-12 d-flex justify-content-end">
                                                <p class="bg-white p-1"><i class="fab fa-cc-visa"></i></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-8">
                                                <input type="text" class="form-control form-control-payment" name="titulaire" required placeholder="NOM DU TITULAIRE DE LA CARTE">
                                                $errTitulaire
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-8">
                                                <input type="number" class="form-control form-control-payment" name="numero-carte" required placeholder="NUMERO DE CARTE">
                                                $errNumber
                                            </div>
                                        </div>
                                        <div class="row d-flex">
                                            <p class="col-3 text-white mt-2">Date d'EXP</p>
                                            <div class="col-3">
                                                <select name="month" id="month" class="custom-select text-white">
                                                    $months
                                                </select>
                                            </div>
                                            <div class="col-3">
                                                <select name="year" id="year" class="custom-select text-white">
                                                    $years
                                                </select>
                                            </div>
                                            <div class="col-3">
                                                <input type="number" class="form-control form-control-payment" name="cvv" required placeholder="CVV">
                                                <p class="d-none form-text text-danger error"></p>
                                            </div>
                                        </div>
                                        $errOther
                                    </div>
                                    <div class="d-flex justify-content-center mt-2">
                                        <button type="submit" class="btn btn-dark px-3">Valider</button>
                                    </div>
                                </form>
                        </div>
                    </div>
                </div>
HTML;
        }

        private static function monthSelectComponent(){
            $component = '<option value="0" selected>MM</option>';
            for($i = 1; $i <= 9; $i++){
                $component = $component . "<option value=\"$i\">0$i</option>";
            }
            for($i = 10; $i <= 12; $i++){
                $component = $component . "<option value=\"$i\">$i</option>";
            }
            return $component;
        }

        private static function yearSelectComponent(){
            $component = '<option value="0" selected>YYYY</option>';
            for($i = 2021; $i <= 2035; $i++){
                $component = $component . "<option value=\"$i\">$i</option>";
            }
            return $component;
        }
    }
?>