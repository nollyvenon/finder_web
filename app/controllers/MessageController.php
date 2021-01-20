<?php

namespace App\Controllers;

use Core\Session;
use Core\Controller;

class MessageController extends Controller
{

    public function __construct($controller, $action)
    {
        parent::__construct($controller, $action);
        $this->loadModel('Messages');
    }

    public function fetchAction($auth, $start) {
        echo json_encode($this->MessagesModel->fetch($auth, $start));
    }

    public function fetchUniqueAction($uniqueId, $auth) {
        echo json_encode($this->MessagesModel->fetchUnique($uniqueId, $auth));
    }

    public function getUnreadCountAction($auth) {
        echo json_encode([["unreadCount" => $this->MessagesModel->getUnreadCount($auth)]]);
    }

    public function addAction()
    {
            if($_POST) {
                $this->MessagesModel->assign($_POST);
                if($this->MessagesModel->add()) {
                    echo json_encode(["status" => true]);
                } else {
                    echo json_encode(["status" => false]);
                }
            }
    }

    public function removeAction($uniqueId) {
        if($this->MessagesModel->remove($uniqueId)) {
            echo json_encode(["status" => true]);
        }
    }
}