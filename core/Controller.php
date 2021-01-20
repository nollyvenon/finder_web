<?php

namespace Core;

use Core\Application;
use Core\View;
use Core\Session;

class Controller extends Application
{

    protected $action, $controller;
    public $view, $viewData = [];

    public function __construct($controller, $action)
    {
        parent::__construct();

        $this->controller = $controller;
        $this->action = $action;
        $this->view = new View();

        //$this->APIheaders();
    }

    protected function loadModel($model)
    {
        $modelPath = 'App\Models\\' . $model;
        if (class_exists($modelPath)) {
            $this->{$model . 'Model'} = new $modelPath();
        }
    }

    protected function view($viewName)
    {
        $this->view->render($viewName);
    }

    protected function addToView($data)
    {
        foreach ($data as $key => $value) {
            $this->viewData[$key] = $value;
        }
    }

    public function setFormErrors($errors = [])
    {
        foreach ($errors as $error) {
            if (Session::get("api")) {
                $this->viewData[$error[1] . 'error'] = $error[0];
            } else {
                $this->viewData[$error[1] . '_error'] = '<span class="inputError">' . $error[0] . '</span>';
            }
        }
    }

    protected function APIheaders()
    {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
    }
}