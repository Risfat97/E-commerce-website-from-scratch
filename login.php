<?php
    namespace App;

    require_once 'autoload/autoloaderLauncher.php';

    use App\user\controller as uc;
    use App\services as sv1;
    use App\user\model as mdl;
    use App\basket\model as mdl2;

    $basketRepo = new mdl2\BasketRepository();
    $loginUserController = new uc\LoginController(new mdl\DatabaseUserRepository());

    sv1\ComponentService::render('Connexion', 
                                $basketRepo->getNbItems(), 
                                $loginUserController->action());
?>
