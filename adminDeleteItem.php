<?php

    namespace App;

    require_once 'autoload/autoloaderLauncher.php';

    use App\ListItem\model as mdl;

    $image = $_POST['url'];

    $image = str_replace('assets/items/', '', $image);

    echo $image;

    $db = new mdl\DatabaseListItemRepository();

    $query = 'delete from articles where image = ?';

    $db->deleteItem($query, [$image]);
    unlink('assets/items/' . $image);
?>
