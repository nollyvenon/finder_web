<?php

namespace App\Models;

use Core\Model;

class Proposals extends Model
{
    public $description, $adId, $findId, $benefit, $category, $auth;

    public function __construct()
    {
        parent::__construct('proposals');
    }

    public function add()
    {
        $bidderID = $this->fetchAuthID();

        $res0 = $this->query("SELECT category FROM ads WHERE category = ? AND adId = ?", 
                [$this->category, $bidderID])->getResult();
        if(count($res0) < 1) return false;

        $res = $this->query("SELECT benefit FROM proposals 
                                    WHERE findId = ? AND adId = ?", 
                                    [$this->findId, $bidderID])->getResult();

        if(count($res) > 0) return false;

        $res1 = $this->query("SELECT findId FROM finds WHERE id = ?", [$this->findId])->getResult()[0];

        $proposals = $this->query("SELECT proposals FROM finds 
                        WHERE findId = ?", [$this->findId])->getResult()[0]->proposals;

        $this->query("UPDATE finds SET proposals = ? WHERE id = ?", [$proposals + 1, $this->findId]);

        return $this->insert([
            'findId' => $this->findId,
            'adId' => $bidderID,
            'finderId' => $res1->findId,
            'description' => $this->description,
            'benefit' => $this->benefit,
            'createdAt' => date('Y-m-d H:i:s')
        ]);
    }

    private function fetchAuthID() {
        $sql = "SELECT id FROM users WHERE auth = ?";
        return $this->query($sql, [$this->auth])->getResult()[0]->id;
    }
    
    public function fetch($findId, $start) {
        $sql = "SELECT proposals.id, proposals.adId, proposals.findId, proposals.description,
                proposals.benefit, users.businessName, users.profileImage, users.rating, users.reviewCount, users.auth 
                FROM proposals 
                LEFT JOIN users
                ON proposals.adId = users.id
                WHERE proposals.findId = ? ORDER BY proposals.id DESC LIMIT  $start, 10";
        $res = $this->query($sql, [$findId])->getResult();
        if(count($res)) return $res;
        return [];
    }

}