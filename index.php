<?php

#Настроки
ini_set('display_errors', '1');


#Автоподгрузка компонентов с моделями и определение корневой папки
define('ROOT', dirname(__FILE__));
require_once(ROOT . '/components/Autoload.php');

#Router
$router = new Router();
$router->run();

?>
