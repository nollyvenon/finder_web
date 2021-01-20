<?php

namespace App\Controllers;

use Core\Controller;

class FeedbackController extends Controller
{

    public function __construct($controller, $action)
    {
        parent::__construct($controller, $action);
        $this->loadModel('Feedbacks');
    }

    public function fetchByProfileAction($userId, $start) {
        echo json_encode($this->FeedbacksModel->fetchByProfile($userId, $start));
    }

    public function fetchByProfileByAuthAction($userId, $start) {
        echo json_encode($this->FeedbacksModel->fetchByProfileByAuth($userId, $start));
    }

    public function fetchByAdAction($adId, $start) {
        echo json_encode($this->FeedbacksModel->fetchByAd($adId, $start));
    }

    public function addAction()
    {
        if($_POST) {
            $this->FeedbacksModel->assign($_POST);
            if($this->FeedbacksModel->add()) {
                echo json_encode(["status" => true]);
            } else {
                echo json_encode(["status" => false]);
            }
        }
    }

}