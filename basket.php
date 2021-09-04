<?php
    namespace App;

    require_once 'autoload/autoloaderLauncher.php';

    use App\services as sv1;
    use App\basket\controller as ctrl;
    use App\basket\model as mdl;

    $basketRepo = new mdl\BasketRepository();
    $basketController = new ctrl\BasketController($basketRepo);
    sv1\ComponentService::render('Panier', $basketRepo->getNbItems(), $basketController->showBasket());
?>