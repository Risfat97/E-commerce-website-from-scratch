<?php
    namespace App\services;

    class ComponentService{

        public static function render($title, $nbCommande, ...$components){
            $authService = new AuthService();
            $basketLink = '';
            if ($authService->isUserConnected())
            {
                if ($authService->getUserData()->isAdmin())
                    $contentLeft = self::htmlContentLeftNavbarForAdmin($authService);
                else
                {
                    $contentLeft = self::htmlContentLeftNavbarIfUserConnected($authService);
                    $basketLink = self::basketArea($nbCommande);
                }
            }
            else
            {
                $contentLeft = self::htmlContentLeftNavbarIfUserNotConnected();
                $basketLink = self::basketArea($nbCommande);
            }
            echo <<<HTML
                <!DOCTYPE html>
                <html lang="fr">
                <head>
                    <meta charset="UTF-8">
                    <meta http-equiv="X-UA-Compatible" content="IE=edge">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet" type="text/css">
                    <link rel="stylesheet"
                        href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
                        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
                        crossorigin="anonymous">
                    <link rel="stylesheet" href="styles/style.css">
                    <title>$title</title>
                    <script src="https://kit.fontawesome.com/317a8531b1.js" crossorigin="anonymous"></script>
                </head>
                <body>
                    <nav class="navbar bg-dark fixed-top">
                        <a href="index.php" class="navbar-brand text-danger">Y<i class="fas fa-glass-cheers"></i>N</a>
                        <ul class="nav ml-auto mr-2">
                            $contentLeft
                            $basketLink
                        </ul>
                    </nav>
                    <div class="container-fluid">
                        <div class="row">
HTML;
            foreach($components as $component)
                echo $component;
            echo <<<HTML
                        </div>
                    </div>

                    <script src="https://code.jquery.com/jquery-3.5.0.min.js"></script>
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" 
                        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" 
                        crossorigin="anonymous"></script>
                    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" 
                        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" 
                        crossorigin="anonymous"></script>
                    <script src="js/triggers.js"></script>
                    <script src="js/app.js"></script>
                </body>
                </html>
HTML;
        }

        private static function htmlContentLeftNavbarIfUserNotConnected(){            
            return <<<HTML
                <li class="nav-item dropdown pt-2">
                    <a href="#" class="navbar-link dropdown-toggle text-light" 
                        id="navbarDropDown" 
                        role="button"
                        data-toggle="dropdown" 
                        aria-haspopup="true" 
                        aria-expanded="false"><i class="fas fa-user"></i> Connexion</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropDown">
                        <div class="px-1"><a class="dropdown-item bg-dark text-light text-center" 
                                                href="login.php">Se connecter</a></div>
                        <a class="dropdown-item" href="signin.php">Créer un compte</a>
                    </div>
                </li>
HTML;
        }

        private static function htmlContentLeftNavbarIfUserConnected($authService){   
            $name = $authService->getUserData()->getNomComplet();       
            return <<<HTML
                <li class="nav-item dropdown pt-2">
                    <a href="#" class="navbar-link dropdown-toggle text-light" 
                        id="navbarDropDown" 
                        role="button"
                        data-toggle="dropdown" 
                        aria-haspopup="true" 
                        aria-expanded="false"><i class="fas fa-user"></i> $name</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropDown">
                        <a class="dropdown-item" href="history.php">Voir commandes</a>
                        <div class="px-1"><a class="dropdown-item bg-dark text-light text-center" 
                                                href="logout.php">Se déconnecter</a></div>
                    </div>
                </li>
HTML;
        }

        private static function htmlContentLeftNavbarForAdmin($authService)
        {
            $name = $authService->getUserData()->getNomComplet();       
            return <<<HTML
                <li class="nav-item dropdown pt-2">
                    <a href="#" class="navbar-link dropdown-toggle text-light" 
                        id="navbarDropDown" 
                        role="button"
                        data-toggle="dropdown" 
                        aria-haspopup="true" 
                        aria-expanded="false"><i class="fas fa-user"></i> $name</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropDown">
                        <a class="dropdown-item" href="adminAddItems.php">Ajouter articles</a>
                        <div class="px-1"><a class="dropdown-item bg-dark text-light text-center" 
                                                href="logout.php">Se déconnecter</a></div>
                    </div>
                </li>
HTML;
        }

        private static function basketArea($nbCommande)
        {
            return <<<HTML
                        <li class="nav-item icon-basket-container">
                                <a href="basket.php" class="nav-link text-light cart-icon" title="Voir mon panier">
                                    <i class="fas fa-shopping-bag"></i> Panier (<span class="nb-order">$nbCommande</span>)</a></li>
HTML;
        }
    }
?>