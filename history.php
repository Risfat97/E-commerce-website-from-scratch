<?php
    namespace App;

    require_once 'autoload/autoloaderLauncher.php';

    use App\services as sv1;
    use App\history\controller as ctrl1;
    use App\history\model as mdl;
    use App\basket\model as mdl2;

    $basketRepo = new mdl2\BasketRepository();
    $historyCtrl = null;
    $historyComponent = '';
    try{
        $historyCtrl = new ctrl1\HistoryController(new mdl\DatabaseHistoryRepository());
        $historyComponent = $historyCtrl->action();
    } catch(\Exception $e){
        echo $e->getMessage();
    }
    sv1\ComponentService::render('Historique', $basketRepo->getNbItems(), $historyComponent);
?>