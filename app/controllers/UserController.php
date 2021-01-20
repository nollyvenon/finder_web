<?php

namespace App\Controllers;

use Core\Session;
use Core\Controller;
use Core\Validation;
use Core\Sanitise;

class UserController extends Controller
{

    public function __construct($controller, $action)
    {
        parent::__construct($controller, $action);
        $this->loadModel('Users');
    }

    public function userByAuthAction($auth)
    {
        echo json_encode($this->UsersModel->findFirst(['conditions' => 'auth = ?', 'bind' => [$auth]]));
    }

    public function userByIdAction($id)
    {
        echo json_encode($this->UsersModel->findFirst(['conditions' => 'id = ?', 'bind' => [$id]]));
    }

    public function registerAction()
    {
        if ($_POST) {
            $imagePath = $_POST['profileImage'] == "" ? "" : 'public/images/profile_pic/' . time() . random_int(1, 100) . '.jpg';
            if ($_POST['profileImage'] != "") file_put_contents($imagePath, base64_decode($_POST['profileImage']));

            /**Assigns the value of $_POST properties to the properties of the 
             * UsersModel object*/
            $this->UsersModel->assign($_POST);
            $this->UsersModel->profileImage = $imagePath;

            $auth = time() . "" . random_int(1, 1000);
            $this->UsersModel->auth = $auth;

            $res = $this->UsersModel->fetchByPhone($this->UsersModel->verifiedPhoneNumber);

            unlink($res->profileImage);

            if ($res == false) {
                $password = Sanitise::get('password');
                $this->UsersModel->password = password_hash($password, PASSWORD_DEFAULT);
                if ($this->UsersModel->register()) echo json_encode(["status" => true, "auth" => $auth]);
            } else {
                $this->UsersModel->auth = $auth = $res->auth;
                if ($this->UsersModel->patch()) echo json_encode(["status" => true, "auth" => $auth, "id" => $res->id]);
            }
        }
    }

    public function checkByPhoneAction(String $PhoneNumber)
    {
        $res = $this->UsersModel->fetchByPhone($PhoneNumber);
        if ($res != false) {
            echo json_encode(["status" => true, "auth" => $res->auth, "userType" => $res->userType]);
            return;
        }
        echo json_encode(["status" => false]);
    }

    public function editProfileAction()
    {

        $res =  $this->UsersModel->findFirst([
            "conditions" => 'user_id = ?',
            "bind" => [Session::get(USER_SESSION_NAME)]
        ]);

        if ($_POST) {
            $this->UsersModel->assign($_POST);

            //instantiate the Validation class
            $validate = new Validation();
            $validate->check('$_POST', $this->UsersModel->validateEdit(), false);

            if ($validate->passed() && $this->UsersModel->editProfile($res->profile_image)) {

                $res =  $this->UsersModel->findFirst([
                    "conditions" => 'user_id = ?',
                    "bind" => [Session::get(USER_SESSION_NAME)]
                ]);
            }
        }

        $this->view('user/editProfile');
    }

    public function setPremiumAction($auth, $premium)
    {
        return $this->UsersModel->update(
            'auth = ?',
            [$auth],
            ['isPremium' => $premium]
        );
    }

    public function uAction($start = 0)
    {
        $this->view->users = $res = $this->UsersModel->fetchUsers($start);
        $this->view->current = "users";
        $start = $start * 20;
        $this->view->current_page = $start == 0 ? 1 : ceil($start / 20);
        $this->view->has_next = count($res) > 19 ? true : false;
        $this->view("user/user");
    }

    public function banAction(int $user_id)
    {
        if ($this->UsersModel->banUser($user_id)) {
            echo json_encode(["status" => true]);
        }
    }

    public function stopBanAction(int $user_id)
    {
        if ($this->UsersModel->stopBanUser($user_id)) {
            echo json_encode(["status" => true]);
        }
    }

    //search user action performed only by the admin from the admin panel
    public function searchAction($search)
    {
        $users = $this->UsersModel->searchAdminUser($search);
        echo json_encode(["users" => $users]);
    }
}
