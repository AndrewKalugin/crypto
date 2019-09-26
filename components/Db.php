<?php

class Db
{
    public static function getConnection()
    {
        #Параметры подключения
        $paramsPath = ROOT . '/config/db_params.php';
        $params = include($paramsPath);

        $sql_db = "mysql:host={$params['host']};dbname={$params['dbname']}";
        $db = new PDO ($sql_db, $params['user'], $params['password']);
        return $db;
    }
}

?>