<?php

namespace App\Controllers;

use Core\Session;
use Core\Controller;

class SearchController extends Controller
{

    public function __construct($controller, $action)
    {
        parent::__construct($controller, $action);
        $this->loadModel('Ads');
        $this->loadModel('Finds');
    }

    public function searchAction($search)
    {
        $ads = $this->AdsModel->search($search);
        $finds = $this->FindsModel->search($search);
        $result = array_merge($ads, $finds);
        echo json_encode($result);
    }

    
}

?>