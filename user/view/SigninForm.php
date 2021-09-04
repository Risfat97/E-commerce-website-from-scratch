<?php

namespace App\user\view;

class SigninForm{

    public static function render($errors, $values){
        $nom = $values['lastName'];
        $prenom = $values['firstName'];
        $username = $values['username'];
        $errorMsgDisplay = ($errors['error'] === false) 
                            ? self::errorHtml($errors['lastName'], $errors['firstName'], $errors['username'], $errors['password'])
                            : self::userAlreadyExists();

        return <<<HTML
        <div class="container auth-container">
            <div class="row d-flex justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="text-center card-title"> Inscription </h2>
                            $errorMsgDisplay
                            <form action="" method="post">
                                <div class="form-group">
                                    <label for="nom"> Nom: </label>
                                    <input type="text" 
                                            name="nom" 
                                            class="form-control"
                                            value="$nom">
                                </div>
                                <div class="form-group">
                                    <label for="prenom"> Prenom: </label>
                                    <input type="text" 
                                            name="prenom" 
                                            class="form-control" 
                                            value="$prenom">
                                </div>
                                <div class="form-group">
                                    <label for="username"> Nom d'utlisateur: </label>
                                    <input type="text" 
                                            name="username" 
                                            value="$username" 
                                            class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="password"> Mot de passe: </label>
                                    <input type="password" name="password" 
                                            class="form-control">
                                </div>
                                <div class="col-12 d-flex justify-content-center">
                                    <button type="submit" class="btn btn-primary"> S'inscrire </button>
                                    <a href="login.php" class="btn btn-link text-dark"> J'ai déja un compte </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
HTML;
    }

    private static function errorHtml($errNom, $errPrenom, $errUsername, $errorPwd){
        $listError = '';
        if($errNom)
            $listError = $listError . '<li>Le nom doit contenir au moins deux caractères</li>';
        if($errPrenom)
            $listError = $listError . '<li>Le prénom doit contenir au moins deux caractères</li>';
        if($errUsername)
            $listError = $listError . "<li>L'email n'est pas au bon format, exemple d'email: name@domain.com</li>";
        if($errorPwd)
            $listError = $listError . "<li>Le mot de passe doit contenir au moins 6 caractères.</li>";
        if($listError !== '')
            return <<<HTML
                <div class="alert alert-danger">
                    <ul>
                        $listError
                    </ul>
                </div>
HTML;
        return '';
    }

    private static function userAlreadyExists(){
        return <<<HTML
                <div class="alert alert-danger">
                    <ul>
                        <li>Ce nom d'utilisateur existe déja.</li>
                    </ul>
                </div>
HTML;
    }
}
?>