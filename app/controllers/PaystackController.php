<?php

namespace App\Controllers;

use Core\Session;
use Core\Controller;

class PaystackController extends Controller
{

    public function __construct($controller, $action)
    {
        parent::__construct($controller, $action);
        $this->loadModel('Users');
        $this->view->setLayout("paystack");
    }

    public function authAction($auth) {
        $user = $this->UsersModel->findFirst(['conditions'=>'auth = ?', 'bind'=>[$auth]]);
        $this->view->ads = $user;
        $this->view('paystack/paystack');
    }

    public function userById($id) {
        $user = $this->UsersModel->findFirst(['conditions'=>'id = ?', 'bind'=>[$id]]);
    }
}
