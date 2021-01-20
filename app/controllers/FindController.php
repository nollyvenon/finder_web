<?php

namespace App\Controllers;

use Core\Session;
use Core\Controller;

class FindController extends Controller
{

    public function __construct($controller, $action)
    {
        parent::__construct($controller, $action);
        $this->loadModel('Finds');
    }

    public function fetchDetailAction($id) {
        echo json_encode($this->FindsModel->findFirst(['conditions'=>'id = ?', 'bind'=>[$id]]));
    }

    public function fAction($start = 0) {
        $this->view->finds = $res = $this->FindsModel->fetch($start);
        $this->view->current = "find";
        $start = $start * 20;
        $this->view->current_page = $start == 0 ? 1 : ceil($start / 20);
        $this->view->has_next = count($res) > 19 ? true : false ;
        $this->view('finds/finds');
    }

    public function fetchAllAction($start) {
        echo json_encode($this->FindsModel->fetchAll($start));
    }

    public function fetchRecentAction() {
        echo json_encode($this->FindsModel->fetchRecent());
    }

    public function fetchByAuthAction($auth, $start) {
        echo json_encode($this->FindsModel->fetchById($auth, $start));
    }

    public function fetchByCategoryAction($cid, $start) {
        echo json_encode($this->FindsModel->fetchByCategory($cid, $start));
    }

    public function addAction()
    {
            if($_POST) {
                $this->FindsModel->assign($_POST);
                if($this->FindsModel->add()) {
                    echo json_encode(["status" => true]);
                } else {
                    echo json_encode(["status" => false]);
                }
            }
    }

    public function removeAction($id) {
        if($this->FindsModel->remove($id)) {
            echo json_encode(["status" => true]);
        }
    }
}