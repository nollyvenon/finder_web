<?php

namespace App\Controllers;

use Core\Session;
use Core\Controller;

class AdController extends Controller
{

    public function __construct($controller, $action)
    {
        parent::__construct($controller, $action);
        $this->loadModel('Ads');
        $this->loadModel('Category');
    }

    public function indexAction()
    {
        if (Session::exists(USER_SESSION_NAME)) {
            $this->view->ads = $this->AdsModel->fetchAll(0);
        }
        
        $this->view('ads/ads');
    }

    public function aAction($start = 0)
    {
        $this->view->ads = $res = $this->AdsModel->fetchAll($start);
        $this->view->current = "ad";
        $start = $start * 20;
        $this->view->current_page = $start == 0 ? 1 : ceil($start / 20);
        $this->view->has_next = count($res) > 19 ? true : false ;
        $this->view('ads/ads');
    }

    public function fetchDetailAction($id, $auth) {
        echo json_encode($this->AdsModel->fetchDetail($id, $auth));
    }

    public function fetchAllAction($start) {
        echo json_encode($this->AdsModel->fetchAll($start));
    }

    public function fetchRecentAction() {
        echo json_encode($this->AdsModel->fetchRecent());
    }

    public function fetchByAuthAction($auth, $start) {
        echo json_encode($this->AdsModel->fetchById($auth, $start));
    }

    public function fetchByCategoryAction($cid, $start) {
        echo json_encode($this->AdsModel->fetchByCategory($cid, $start));
    }

    public function likeAction($id, $auth) {
        echo json_encode($this->AdsModel->like($id, $auth));
    }

    public function addAction()
    {
        if($_POST) {
            $imagePath = $_POST['image'] == "" ? "" : 'public/images/post_pic/' . time().random_int(1, 100).'.jpg';
            if($_POST['image'] != "") file_put_contents($imagePath, base64_decode($_POST['image']));

            //add
            $attachmentPath = $_POST['attachment'] == "" ? "" : 'public/doc/' . time().random_int(1, 100).'.pdf';
            if($_POST['attachment'] != "") file_put_contents($attachmentPath, base64_decode($_POST['attachment']));
            //add

            $this->AdsModel->assign($_POST);
            $this->AdsModel->image = $imagePath;
            $this->AdsModel->attachment = $attachmentPath;

            $count = $this->CategoryModel->getCategoryCount($this->AdsModel->categoryId());
            $this->CategoryModel->patchCount($this->AdsModel->categoryId(), $count + 1);

            if($this->AdsModel->add()) {
                echo json_encode(["status" => true]);
            } else {
                echo json_encode(["status" => false]);
            }
        }
    }

    public function removeAction($id) {
        if($this->AdsModel->remove($id)) {
            $count = $this->CategoryModel->getCategoryCount($this->AdsModel->getCategoryId($id));
            $this->CategoryModel->patchCount($this->AdsModel->getCategoryId($id), $count - 1);
            echo json_encode(["status" => true]);
        }
    }
}