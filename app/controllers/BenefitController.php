<?php

namespace App\Controllers;

use Core\Controller;
use Core\Router;
use Core\Session;

class BenefitController extends Controller
{

    public function __construct($controller, $action)
    {
        parent::__construct($controller, $action);
        $this->loadModel('Benefits');
    }

    public function indexAction()
    {
        $this->view->benefits = $this->BenefitsModel->fetchAll();
        $this->view->current = "benefit";
        $this->view->count = $this->BenefitsModel->getCount();
        $this->view('benefits/benefit');
    }

    public function fetchAction()
    {
        echo json_encode($this->BenefitsModel->fetchAll());
    }

    public function formAction($id = 0)
    {
        if (!Session::exists(USER_SESSION_NAME)) Router::redirect('login');
        $this->view->benefit = $this->BenefitsModel->findFirst(['conditions'=>'id = ?', 'bind'=>[$id]]);

        if($_POST && $id != 0) {
            $this->BenefitsModel->assign($_POST);
            if($this->BenefitsModel->patch($id)) {
                $this->view->benefit = $this->BenefitsModel->findFirst(['conditions'=>'id = ?', 'bind'=>[$id]]);
                Router::redirect('benefit');
            }
        }

        if($_POST && $id == 0) {
            $this->BenefitsModel->assign($_POST);
            if($this->BenefitsModel->add()) {
                $this->view->benefit = $this->BenefitsModel->findFirst(['conditions'=>'id = ?', 'bind'=>[$id]]);
                Router::redirect('benefit');
            }
        }

        $this->view->current = "benefit";
        $this->view('benefits/form');
    }

    public function removeAction($id) {
        if (!Session::exists(USER_SESSION_NAME)) Router::redirect('login');
        if($this->BenefitsModel->remove($id)) {
            Router::redirect('benefit');
        }
    }
}