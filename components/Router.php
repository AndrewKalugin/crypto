<?php

class Router
{
    private $routes;

    public function __construct()
    {
        $routesPath = ROOT . '/config/routes.php';
        $this->routes = include($routesPath);
    }

    #Возвращает запрос из адресной строки
    private function getURI()
    {
        if (!empty($_SERVER['REQUEST_URI'])) {
            return trim($_SERVER['REQUEST_URI'], '/');
        }
    }

    public function run()
    {
        $uri = $this->getURI();
        foreach ($this->routes as $uriPattern => $path) {
            if (preg_match("~$uriPattern~", $uri)) {

                #Определение контроллера и действия
                $segment = explode('/', $path);
                $controllerName = ucfirst(array_shift($segment)) . 'Controller';
                $actionName = 'action' . ucfirst(array_shift($segment));

                #Подключение контроллера
                $controllerFile = ROOT . '/controllers/' . $controllerName . '.php';
                if (file_exists($controllerFile)) {
                    include_once($controllerFile);
                }

                #Вызываем метод
                $controllerObject = new $controllerName;
                $result = $controllerObject->$actionName();
                if($result != null){
                    break;
                }
            }
        }
    }
}


?>