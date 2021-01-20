<?php
    namespace App\Controllers;
    use Core\Controller;
    use Core\Validation;
    use Core\Sanitise;
    use Core\Router;
    use App\Libs\Email;
    use App\Libs\EmailLayout;

    class PasswordController extends Controller {
        private $email; 
        public function __construct($controller, $action) {
            parent::__construct($controller, $action);
            $this->loadModel('Users');
            $this->email = new Email();
            
            $this->view->setLayout('reglog');
        }

        public function forgotAction() {
            $code = md5(uniqid(true));

            if($_POST) {
                $validate = new Validation();
                $validate->check('$_POST', [
                    'email' => ['display'=>'Email', 'required'=>true, 'isEmail' => true]
                ], false);
    
                if($validate->passed()) {
                    $this->UsersModel->email = sanitise::get('email');
                    $result = $this->UsersModel->findUser();
                    if(!empty($result)) {
                        $this->email->reply_email = '';
                        $this->email->setEmailSubject('Password Reset Link');
                        $this->email->setRecipientEmail($result[0]->email);
                        $content = EmailLayout::passwordLayout($code, sanitise::get('email'));
                        $this->email->setEmailContent($content);
                        
                        if($this->email->sendEmail()) {
                            $this->viewData["success"] ='A reset link has been sent to your email';
                        } else {
                            $this->viewData["danger"] ='There was connection error';
                        }
                    } else {
                        $this->viewData["danger"] ='Email does not exist in the database';
                    }
                } else {
                    $this->viewData["danger"] ='Enter a valid email';
                }
            }

            $this->view('password/forgot');
        }

        public function ResetAction($code='', $email='') {
            $this->viewData["code"] = $code; 
            $this->viewData["email"] = $email; 
            if($_POST) {
                $validate = new Validation();
                $validate->check('$_POST', [
                    'password_one' => ['display' => 'Password', 'min' => 8, 'required' => true]
                ]);
                    
                if($validate->passed()) {
                    $password = Sanitise::get('password_one');
                    $confirm_password = Sanitise::get('password_two');

                    if($password === $confirm_password) {
                        $this->UsersModel->password = password_hash($password, PASSWORD_DEFAULT); 
                        $this->UsersModel->email = $email;
                        $this->UsersModel->pwd_retrieve = '';
                        $registered = $this->UsersModel->resetPassword();    
                        
                        ($registered) ? Router::redirect('login') : $this->viewData["danger"] = 'Error encountered'; 
                    } 
                    $this->viewData["danger"] = 'Password does not match';
                }
                $this->viewData["danger"] = 'Password should not be less than 8 characters';
            }
            $this->view('password/reset');
        }


    }