<?php

namespace App\Models;

use Core\Model;
use Core\Session;

class Finds extends Model
{
    public $description, $proposals = 0, $title, $price, $benefit, $category, $auth;

    public function __construct()
    {
        parent::__construct('finds');
    }

    public function add()
    {
        $date = date('Y/m/d H:i');
        $bidEnd = date('Y/m/d H:i', strtotime($date. ' + 7 days'));

        return $this->insert([
            'findId' => $this->fetchAuthID(),
            'type' => "finds",
            'description' => $this->description,
            'title' => $this->title,
            'price' => $this->price,
            'benefit' => $this->benefit,
            'category' => $this->categoryId(),
            'proposals' => $this->proposals,
            'createdAt' => $date,
            'bidEnd' => $bidEnd
        ]);
    }

    private function categoryId() {
        $sql = "SELECT id FROM category WHERE `name` = ?";
        return $this->query($sql, [$this->category])->getResult()[0]->id;
    }

    private function fetchAuthID() {
        $sql = "SELECT id FROM users WHERE auth = ?";
        return $this->query($sql, [$this->auth])->getResult()[0]->id;
    }

    public function fetchRecent() {
        $res = $this->query("SELECT finds.*, users.auth 
                            FROM finds 
                            LEFT JOIN users 
                            ON finds.findId = users.id 
                            ORDER BY finds.id DESC LIMIT 5")->getResult();
        if(count($res)) return $res;
        return [];
    } 
    
    public function fetchAll($start) {
        $res = $this->query("SELECT finds.*, users.auth 
                            FROM finds 
                            LEFT JOIN users 
                            ON finds.findId = users.id 
                            ORDER BY finds.id DESC LIMIT $start, 10")->getResult();
        if(count($res)) return $res;
        return [];
    } 
    
    public function fetch($start) {
        $res = $this->query("SELECT finds.*, users.auth 
                            FROM finds 
                            LEFT JOIN users 
                            ON finds.findId = users.id 
                            ORDER BY finds.id DESC LIMIT $start, 20")->getResult();
        if(count($res)) return $res;
        return [];
    }

    public function fetchById($auth, $start) {
        $this->auth = $auth;
        $res = $this->query("SELECT finds.*, users.auth 
                            FROM finds 
                            LEFT JOIN users 
                            ON finds.findId = users.id 
                            WHERE users.id = ?
                            LIMIT $start, 10", [$this->fetchAuthID()])->getResult();
        if(count($res)) return $res;
        return false;
    }

    public function getCount() {
        $res = $this->query("SELECT * FROM finds")->getResult();
        return count($res);
    }

    public function fetchByCategory($cId, $start) {
        $res = $this->query("SELECT finds.*, users.auth
                            FROM finds 
                            LEFT JOIN users 
                            ON finds.findId = users.id 
                            WHERE category = ?
                            LIMIT $start, 10", [$cId])->getResult();
        if(count($res)) return $res;
        return [];
    }

    public function search($params) {
        return $this->query("SELECT finds.*, users.auth 
                                FROM finds 
                                LEFT JOIN users 
                                ON finds.findId = users.id 
                                WHERE title LIKE '%".$params."%' LIMIT 5")->getResult();
    }

    public function remove($id)
    {
        $this->query("DELETE FROM finds WHERE id = ?", [$id]);
        return true;
    }
}