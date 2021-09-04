<?php
    namespace App;

    require_once 'autoload/autoloaderLauncher.php';

    use App\services as srv;
    use App\filter\controller as fcntl;

    $authService = new srv\AuthService();
    $filterMgr = fcntl\FilterManager::getInstance();

    $authService->logout();
    $filterMgr->deleteData();
    header('Location: index.php');
    exit();
?>