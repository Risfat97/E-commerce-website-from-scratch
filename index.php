<?php
    namespace App;

    require_once 'autoload/autoloaderLauncher.php';

    use App\services as sv1;
    use App\listItemContainer\controller as ctrl1;
    use App\listItem\model as mdl1;
    use App\basket\model as mdl2;

    $basketRepo = new mdl2\BasketRepository();
    $listItemContainerController = null;
    $lisItemComponent = '';
    
    try{
        $listItemContainerController = new ctrl1\ListItemContainerController(new mdl1\DatabaseListItemRepository());
        $lisItemComponent = $listItemContainerController->action();
    } catch(\Exception $e){
        echo $e->getMessage();
    }
    sv1\ComponentService::render('YAN', $basketRepo->getNbItems(), $lisItemComponent);
?>