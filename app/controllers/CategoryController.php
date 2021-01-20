<?php

namespace App\Controllers;

use Core\Session;
use Core\Controller;
use Core\Router;

class CategoryController extends Controller
{

    public function __construct($controller, $action)
    {
        parent::__construct($controller, $action);
        $this->loadModel('Category');
    }

    public function fetchAllAction()
    {
        echo json_encode($this->CategoryModel->fetchAllApi());
    }

    public function fetchRecentAction()
    {
        echo json_encode($this->CategoryModel->fetchRecent()); 
    }

    public function catAction()
    {
        $this->view->cats = $this->CategoryModel->fetchAll(); 
        $this->view->current = "category";
        $this->view('category/category');
    }

    public function formAction($id = 0)
    {
        if (!Session::exists(USER_SESSION_NAME)) Router::redirect('login');
        $this->view->current = "category";
        $id = is_numeric($id) ? $id : 0;

        $res = $this->CategoryModel->findFirst(['conditions'=>'id = ?', 'bind'=>[$id]]);
        $this->view->cat = $cat = !empty($res) ? $res : "" ;

        if($_POST && $id != 0) {
            $this->CategoryModel->assign($_POST);
            if($this->CategoryModel->patch($id)) {
                $this->CategoryModel->uploadImage($cat->image, $cat->id);
                $this->view->cat = $this->CategoryModel->findFirst(['conditions'=>'id = ?', 'bind'=>[$id]]);
                Router::redirect('category/cat');
            }
        }

        if($_POST && $id == 0) {
            $this->CategoryModel->assign($_POST);
            $this->CategoryModel->uploadImage();
            if($this->CategoryModel->add()) {
                $this->view->cat = $this->CategoryModel->findFirst(['conditions'=>'id = ?', 'bind'=>[$id]]);
                Router::redirect('category/cat');
                return;
            }
        }

        $this->view('category/form');
    }

    public function removeAction($id) {
        if (!Session::exists(USER_SESSION_NAME)) Router::redirect('login');
        if($this->CategoryModel->remove($id)) {
            $this->view->current = "category";
            $this->view('category/form');
        }
    }
}