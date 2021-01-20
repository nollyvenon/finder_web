<?php

namespace App\Controllers;

use Core\Session;
use Core\Controller;

class HomeController extends Controller
{
    /********************
     * Call the extended controller construct to 
     * instatiate the view object
     */
    public function __construct($controller, $action)
    {
        parent::__construct($controller, $action);
        $this->loadModel('Users');
        $this->loadModel('Ads');
        $this->loadModel('Category');
        $this->loadModel('Finds');
        $this->loadModel('Slides');
        $this->loadModel('Benefits');
        //$this->loadModel('Follow');
    }

    /***********
     * The default action if no action is provided
     */
    public function indexAction()
    {
        if (Session::exists(USER_SESSION_NAME)) {
            $this->view->user_count = $this->UsersModel->getCount();
            $this->view->ad_count = $this->AdsModel->getCount();
            $this->view->find_count = $this->FindsModel->getCount();
            $this->view->category_count = $this->CategoryModel->getCount();
            $this->view->slide_count = $this->SlidesModel->getCount();
            $this->view->benefit_count = $this->BenefitsModel->getCount();
        }
        
        $this->view->current = "index";
        $this->view('home/home');
    }

}