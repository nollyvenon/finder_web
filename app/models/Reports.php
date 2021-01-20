<?php

namespace App\Models;

use Core\Model;

class Reports extends Model
{
    public $report = "", $auth = 0, $reportedID = 0;

    public function __construct()
    {
        parent::__construct('reports');
    }

    public function add()
    {  
        return $this->insert([
            'report' => $this->report,
            'reporter' => $this->fetchAuthID(),
            'reportedID' => $this->reportedID,
            'createdAt' => date('Y/m/d H:i:s')
        ]);
    } 

    private function fetchAuthID() {
        $sql = "SELECT username FROM users WHERE auth = ?";
        return $this->query($sql, [$this->auth])->getResult()[0]->username;
    }

    public function fetch($start) {
        $res = $this->query("SELECT reports.*, users.username FROM reports 
                LEFT JOIN users 
                ON reports.reported = users.id 
                LIMIT $start, 10")->getResult();
        if(count($res)) return $res;
        return [];
    }

}