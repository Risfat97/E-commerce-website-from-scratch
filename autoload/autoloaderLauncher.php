<?php
namespace App;

require_once 'autoload/Autoloader.php';
try{
    Autoloader::register();
} catch(\Exception $e){
    echo $e->getMessage();
}