<?php

namespace App\Controllers;

use Core\Controller;
use Core\Router;
use Core\Sanitise;
use Core\Validation;
use Core\Session;

class LoginController extends Controller
{

    public function __construct($controller, $action)
    {
        parent::__construct($controller, $action);
        $this->loadModel('Users');

        $this->view->username = $this->view->password = '';
    }

    public function indexAction()
    {
        if (Session::exists(USER_SESSION_NAME)) Router::redirect('');
        $this->view->current = "";
        $this->view->user = null;
        /** validate input*/
        if ($_POST) {
            $validate = new Validation();
            $validate->check('$_POST', [
                'username' => ['display' => 'Username', 'required' => true],
                'password' => ['display' => 'Password', 'required' => true]
            ]);

            /**Assign the input to values to the corresponding Buyer class properties **/
            $this->UsersModel->assign($_POST);

            /**login user if vaidation is passed,
             * user exist in the database and 
             * password is correct**/
            if ($validate->passed()) {
                $user = $this->UsersModel->findUser();

                if (!empty($user)) {
                    if (password_verify($this->UsersModel->password, $user->password)) {
                        Session::set(USER_SESSION_NAME, $user->id);
                        Router::redirect('');
                    } else {
                        $this->viewData["password_error"] = '<span class="inputError">Password is incorrect</span>';
                    }
                } else {
                    $this->viewData["email_error"] = '<span class="inputError">This user does not exist in the database</span>';
                }
            } else {
                $this->setFormErrors($validate->getErrors());
            }
        }

        $this->view('login/login');
    }
}