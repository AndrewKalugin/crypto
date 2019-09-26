<?php

#Настроки
ini_set('display_errors', '1');


#Подключение базы и автоподгрузка компонентов с моделями
define('ROOT', dirname(__FILE__));
require_once(ROOT . '/components/Autoload.php');

#Router
$router = new Router();
$router->run();

?>