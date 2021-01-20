<?php

namespace App\Controllers;

use Core\Session;
use Core\Controller;

class ProposalController extends Controller
{

    public function __construct($controller, $action)
    {
        parent::__construct($controller, $action);
        $this->loadModel('Proposals');
    }

    public function fetchAction($findId, $start) {
        echo json_encode($this->ProposalsModel->fetch($findId, $start));
    }

    public function addAction()
    {
        //if (Session::exists(USER_SESSION_NAME)) {
            if($_POST) {
                $this->ProposalsModel->assign($_POST);
                if($this->ProposalsModel->add()) {
                    echo json_encode(["status" => true]);
                } else {
                    echo json_encode(["status" => false]);
                }
            }
        //}
    }
}