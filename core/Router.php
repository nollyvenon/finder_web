<?php

namespace Core;

use Core\Session;

class Router
{
    public static function route($url)
    {
        if (!empty($url) && $url[0] == "api") {
            Session::set("api", true);
            array_shift($url);
        } else {
            Session::set("api", false);
        }

        $controller = (isset($url[0]) && $url[0] !== '') ? ucwords($url[0]) : DEFAULT_CONTROLLER;
        $controllerName = $controller . 'Controller';
        array_shift($url);

        //get the method for the controller
        $action = (isset($url[0]) && $url[0] !== '') ? $url[0] . 'Action' : 'indexAction';
        array_shift($url);

        //method parameters
        $queryParams = $url;

        if (class_exists('App\Controllers\\' . $controllerName)) {
            $controllerName = 'App\Controllers\\' . $controllerName;
            $dispatch = new $controllerName($controllerName, $action);
        }

        if (method_exists($controllerName, $action)) {
            call_user_func_array([$dispatch, $action], $queryParams);
        } else {
            if (!method_exists($controllerName, $action)) {
                call_user_func_array([$dispatch, 'paramsAction'], $queryParams);
            } else {
                die('This query ' . $action . ' is not valid');
            }
        }
    }

    //Redirect pages
    public static function redirect($location)
    {
        if (!headers_sent()) {
            header('location: ' . PROOT . $location);
            exit();
        } else {
            echo '<script type="text/javascript">';
            echo 'window.location.href = "' . PROOT . $location . '"';
            echo '</script>';

            echo '<noscript>';
            echo '<meta http-equiv="refresh" content="0;url=' . $location . '>';
            echo '</noscript>';
            exit();
        }
    }
}