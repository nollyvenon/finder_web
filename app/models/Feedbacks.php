<?php

namespace App\Models;

use Core\Model;

class Feedbacks extends Model
{
    public $adId, $rating = 0, $feedback, $auth;

    public function __construct()
    {
        parent::__construct('feedbacks');
    }

    public function add()
    {

        $userId = $this->fetchAdOwnerID();
        $finderId = $this->fetchAuthID();

        $res = $this->query("SELECT finderId FROM feedbacks WHERE adId = ? AND finderId = ?", 
                                [$this->adId, $finderId])->getResult();

        if(count($res) > 0) return false;

        $user_res = $this->query("SELECT reviewCount, rating FROM users 
                        WHERE id = ?", [$userId])->getResult()[0];
                        
        $ad_res = $this->query("SELECT review, rating FROM ads 
        WHERE id = ?", [$this->adId])->getResult()[0];

        $this->query("UPDATE ads SET rating = ?, review = ? 
                        WHERE id = ?", [$ad_res->rating + 1, $ad_res->review + 1, $this->adId]);

        $this->query("UPDATE users SET rating = ?, reviewCount = ? 
                WHERE id = ?", [$user_res->rating + 1, $user_res->reviewCount + 1, $userId]);

        return $this->insert([
            'adId' => $this->adId,
            'feedback' => $this->feedback,
            'rating' => $this->rating,
            'finderId' => $finderId,
            'userId' => $userId,
            'createdAt' => date('Y/m/d H:i:s')
        ]);
    } 

    private function fetchAuthID() {
        $sql = "SELECT id FROM users WHERE auth = ?";
        return $this->query($sql, [$this->auth])->getResult()[0]->id;
    }

    private function fetchAdOwnerID() {
        $sql = "SELECT adId FROM ads WHERE id = ?";
        return $this->query($sql, [$this->adId])->getResult()[0]->adId;
    }

    public function fetchByProfile($profileId, $start) {
        $res = $this->query("SELECT feedbacks.*, users.username, users.profileImage, ads.title
                            FROM feedbacks 
                            LEFT JOIN users 
                            ON feedbacks.userId = users.id 
                            LEFT JOIN ads
                            ON feedbacks.adId = ads.id
                            WHERE feedbacks.userId = ?
                            LIMIT $start, 10", [$profileId])->getResult();
        if(count($res)) return $res;
        return [];
    }

    public function fetchByProfileByAuth($auth, $start) {
        $this->auth = $auth;
        $res = $this->query("SELECT feedbacks.*, users.username, users.profileImage, ads.title
                            FROM feedbacks 
                            LEFT JOIN users 
                            ON feedbacks.userId = users.id 
                            LEFT JOIN ads
                            ON feedbacks.adId = ads.id
                            WHERE feedbacks.userId = ?
                            LIMIT $start, 10", [$this->fetchAuthID()])->getResult();
        if(count($res)) return $res;
        return [];
    }

    public function fetchByAd($adId, $start) {
        $res = $this->query("SELECT feedbacks.*, users.username, users.id, users.profileImage, ads.title
                FROM feedbacks 
                LEFT JOIN users 
                ON feedbacks.userId = users.id 
                LEFT JOIN ads
                ON feedbacks.adId = ads.id
                WHERE feedbacks.adId = ?
                LIMIT $start, 10", [$adId])->getResult();
        if(count($res)) return $res;
        return [];
    }

}