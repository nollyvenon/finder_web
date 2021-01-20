<?php

namespace App\Controllers;

use Core\Session;
use Core\Controller;
use Core\Router;

class SlideController extends Controller
{

    public function __construct($controller, $action)
    {
        parent::__construct($controller, $action);
        $this->loadModel('Slides');
    }

    public function indexAction()
    {
        $this->view->slides = $this->SlidesModel->fetchAll();
        $this->view->current = "slide";
        $this->view->count = $this->SlidesModel->getCount();
        $this->view('slides/slide');
    }

    public function fetchAction()
    {
        echo json_encode($this->SlidesModel->fetchAll());
    }

    public function formAction($id = 0)
    {
        if (!Session::exists(USER_SESSION_NAME)) Router::redirect('login');
        $this->view->slide = $cat = $this->SlidesModel->findFirst(['conditions'=>'id = ?', 'bind'=>[$id]]);

        if($_POST && $id != 0) {
            $this->SlidesModel->assign($_POST);
            if($this->SlidesModel->patch($id)) {
                $this->SlidesModel->uploadImage($cat->image, $cat->id);
                $this->view->slide = $this->SlidesModel->findFirst(['conditions'=>'id = ?', 'bind'=>[$id]]);
                Router::redirect('slide');
            }
        }

        if($_POST && $id == 0) {
            $this->SlidesModel->assign($_POST);
            $this->SlidesModel->uploadImage();
            if($this->SlidesModel->add()) {
                $this->view->slide = $this->SlidesModel->findFirst(['conditions'=>'id = ?', 'bind'=>[$id]]);
                Router::redirect('slide');
            }
        }

        $this->view->current = "slide";
        $this->view('slides/form');
    }

    public function removeAction($id) {
        if (!Session::exists(USER_SESSION_NAME)) Router::redirect('login');
        if($this->SlidesModel->remove($id)) {
            Router::redirect('slide');
        }
    }
}