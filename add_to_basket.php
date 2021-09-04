<?php
    namespace App;

    require_once 'autoload/autoloaderLauncher.php';

    use App\basket\controller as ctrl;
    use App\basket\model as mdl;

    $ctrlBasket = new ctrl\BasketController(new mdl\BasketRepository());
    $ctrlBasket->addAction();
?>