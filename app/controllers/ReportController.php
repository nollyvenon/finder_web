<?php

namespace App\Controllers;

use Core\Controller;

class ReportController extends Controller
{

    public function __construct($controller, $action)
    {
        parent::__construct($controller, $action);
        $this->loadModel('Reports');
    }

    public function fetchAction($start) {
        echo json_encode($this->ReportsModel->fetch($start));
    }

    public function addAction()
    {
        if($_POST) {
            $this->ReportsModel->assign($_POST);
            if($this->ReportsModel->add()) {
                echo json_encode(["status" => true]);
            } else {
                echo json_encode(["status" => false]);
            }
        }
    }

}