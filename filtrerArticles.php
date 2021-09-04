<?php
    namespace App;

    require_once 'autoload/autoloaderLauncher.php';

    use App\filter\controller as fcntl;

    $filterMgr = fcntl\FilterManager::getInstance();

    if ($_POST['clear'] === 'false')  
        $filterMgr->action();
    else
        $filterMgr->deleteData();
    echo 'success';
?>