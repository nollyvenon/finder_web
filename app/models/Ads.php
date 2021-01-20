<?php

namespace App\Models;

use Core\Model;

class Ads extends Model
{
    public $description, $rating = 0, $review = 0, $image = '', $attachment = '', $title, $auth,
    $price, $benefit, $views = 0, $likes = 0, $category, $adId, $type = "ads";

    public function __construct()
    {
        parent::__construct('ads');
    }

    public function add()
    {
        return $this->insert([
            'adId' => $this->fetchAuthID(),
            'type' => $this->type,
            'description' => $this->description,
            'rating' => $this->rating,
            'review' => $this->review,
            'image' => $this->image,
            'attachment' => $this->attachment,
            'title' => $this->title,
            'price' => $this->price,
            'benefit' => $this->benefit,
            'views' => $this->views,
            'likes' => $this->likes,
            'category' => $this->categoryId(),
            'createdAt' => date('Y-m-d H:i:s')
        ]);
    } 

    public function categoryId() {
        $sql = "SELECT id FROM category WHERE `name` = ?";
        return $this->query($sql, [$this->category])->getResult()[0]->id;
    }

    public function fetchRecent() {
        $res = $this->query("SELECT ads.*, users.auth 
                            FROM ads 
                            LEFT JOIN users 
                            ON ads.adId = users.id 
                            ORDER BY ads.id DESC LIMIT 5")->getResult();
        if(count($res)) return $res;
        return [];
    }
    
    public function fetchAll($start) {
        $res = $this->query("SELECT ads.*, users.auth, users.businessName 
                            FROM ads 
                            LEFT JOIN users 
                            ON ads.adId = users.id 
                            ORDER BY ads.id DESC LIMIT $start, 20")->getResult();
        if(count($res)) return $res;
        return [];
    }
 
    private function fetchAuthID() {
        $sql = "SELECT id FROM users WHERE auth = ?";
        return $this->query($sql, [$this->auth])->getResult()[0]->id;
    }

    public function fetchById($auth, $start) {
        $this->auth = $auth;
        $res = $this->query("SELECT ads.*, users.auth, users.id 
                            FROM ads 
                            LEFT JOIN users 
                            ON ads.adId = users.id 
                            WHERE users.id = ?
                            LIMIT $start, 10", [$this->fetchAuthID()])->getResult();
        if(count($res)) return $res;
        return [];
    }

    public function getCategoryId($id) {
        return $this->query("SELECT category WHERE id = ?", [$id])->getResult()[0]->category;
    }

    public function fetchByCategory($cId, $start) {
        $res = $this->query("SELECT ads.*, users.auth, users.id, users.businessName 
                            FROM ads 
                            LEFT JOIN users 
                            ON ads.adId = users.id 
                            WHERE category = ?
                            LIMIT $start, 10", [$cId])->getResult();
        if(count($res)) return $res;
        return [];
    }

    public function fetchDetail($id, $auth) {
        $this->auth = $auth;
        $res1 = $auth != null ? $this->query("SELECT id as findId FROM users WHERE auth = ?", [$auth])->getResult()[0] : "";
        $res2 = $auth != null ? $this->query("SELECT id FROM like_record 
                                        WHERE auth = ? AND adId = ?", [$auth, $id])->getResult() : "";

        $res = $this->query("SELECT ads.*, users.businessName, users.location, users.auth 
                            FROM ads 
                            LEFT JOIN users 
                            ON ads.adId = users.id 
                            WHERE ads.id = ?", [$id])->getResult()[0];

        if($auth != null) {
            if(count($this->query("SELECT auth FROM view_record WHERE auth = ? AND adId = ?", [$auth, $id])->getResult()) < 1) {
                $this->query("INSERT INTO view_record (adId, auth) VALUES (?, ?)", [$id, $auth]);
                $this->update('id = ?', [$id], ['views' => $res->views + 1]);
            }
        }

        if($auth != null) {
            $res->liked = count($res2) ? $res2[0]->id : "";
            $res->findId = $res1->findId;
        }

        return $res;
    }

    public function getCount() {
        $res = $this->query("SELECT * FROM ads")->getResult();
        return count($res);
    }

    public function search($params) {
        return $this->query("SELECT  ads.id, ads.title, ads.type, users.auth 
                            FROM ads 
                            LEFT JOIN users 
                            ON ads.adId = users.id 
                            WHERE title LIKE '%".$params."%' LIMIT 5")->getResult();
    }

    public function like($id, $auth) {
        $likes = $this->query("SELECT likes FROM ads WHERE id = ?", [$id])->getResult()[0];
        if(count($this->query("SELECT auth FROM like_record WHERE auth = ? AND adId = ?", [$auth, $id])->getResult()) > 0) {
            $this->query("DELETE FROM like_record WHERE auth = ? AND adId = ?", [$auth, $id]);
            $this->update('id = ?', [$id], ['likes' => $likes->likes - 1]);
            return ["likes" => $likes->likes - 1, "status" => false];
        } else {
            $this->query("INSERT INTO like_record (adId, auth) VALUES (?, ?)", [$id, $auth]);
            $this->update('id = ?', [$id], ['likes' => $likes->likes + 1]);
            return ["likes" => $likes->likes + 1, "status" => true];
        }

    }

    public function remove($id)
    {
        $this->query("DELETE FROM ads WHERE id = ?", [$id]);
        return true;
    }
}