<?php

namespace App\user\view;

class LoginForm
{
    public static function render($errorMsg)
    {
        $errorMsgDisplay = '';

        if(!empty($errorMsg))
        {
            $errorMsgDisplay = <<<HTML
            <div class="modal" tabindex="-1" role="dialog" id="errorModal">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"> Erreur : saisie invalide </h5>
                        </div>
                        <div class="modal-body">
                            <p> $errorMsg </p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"> Fermer </button>
                        </div>
                    </div>
                </div>
            </div>
HTML;
        }
        return <<<HTML
        $errorMsgDisplay

        <div class="container auth-container">
            <div class="row d-flex justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="card-title text-center"> Connexion </h2>
                            <form action="" method="post">
                                <div class="form-group">
                                    <label for="username"> Nom d'utlisateur: </label>
                                    <input type="text" name="username" id="username" placeholder="ex:name@domain.com" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="password"> Mot de passe: </label>
                                    <input type="password" name="password" id="password" class="form-control">
                                </div>
                                <div class="col-12 d-flex justify-content-center">
                                    <button type="submit" class="btn btn-primary"> Se connecter </button>
                                    <a href="signin.php" class="btn btn-link text-dark"> S'inscrire </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
HTML;
    }
}
?>