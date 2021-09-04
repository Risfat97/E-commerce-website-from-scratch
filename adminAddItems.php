<?php

namespace App;

require_once 'autoload/autoloaderLauncher.php';

use App\services as srv;
use App\assetsHandle\controller as acntr;
use App\listItem\model as lmdl;

$assetsHandleController = new acntr\AssetsHandlerController(new lmdl\DatabaseListItemRepository());

srv\ComponentService::render('Ajout d\'un article', '', $assetsHandleController->action());


