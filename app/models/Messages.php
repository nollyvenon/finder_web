<?php

namespace App\Models;

use Core\Model;
use Core\Session;

class Messages extends Model
{
    public $message = "", $uniqueId = "", $viewed = 0, $findId = "", $adId = "", $auth = "";

    public function __construct()
    {
        parent::__construct('messages');
    }

    public function add()
    {
        $sender = $this->fetchAuthID();
        $receiver = $sender == $this->findId ? $this->adId : $this->findId;
        return $this->insert([
            'message' => $this->message,
            'uniqueId' => $this->uniqueId,
            'sender' => $sender,
            'receiver' => $receiver,
            'viewed' => $this->viewed,
            'findId' => $this->findId,
            'adId' => $this->adId,
            'createdAt' => date('Y/m/d H:i:s')
        ]);
    }

    private function fetchAuthID() {
        $sql = "SELECT id FROM users WHERE auth = ?";
        return $this->query($sql, [$this->auth])->getResult()[0]->id;
    }
    
    public function fetch($auth, $start) {
        $this->auth = $auth;
        $id = $this->fetchAuthID();

        $stmt = '';

        $s = "SELECT sender FROM messages
        WHERE messages.sender = ?
        OR messages.receiver = ? ORDER BY mId DESC LIMIT 1";
        $r = $this->query($s, [$id, $id])->getResult()[0];

        if($r->sender == $id) {
            $stmt = "messages.receiver = users.id";
        } else {
            $stmt = "messages.sender = users.id";
        }

        $sql = "SELECT messages.*, users.businessName, users.username 
        FROM messages
        LEFT JOIN users
        ON $stmt
        WHERE messages.sender = ?
        OR messages.receiver = ?
        GROUP BY uniqueId ORDER BY mId DESC LIMIT  $start, 20";

        $res = $this->query($sql, [$id, $id])->getResult();
        if(count($res)) return $res;
        return [];
    }
    
    public function fetchUnique($uniqueId, $auth) {
        $this->auth = $auth;
        $id = $this->fetchAuthID();

        $p = explode("-", $uniqueId);
        $join_sql = $p[0];

        if($p[0] == $id) {
            $join_sql = $p[1];
        }

        $this->update('uniqueId = ? AND viewed = 0', [$uniqueId], ['viewed' => 1]);

        $sql = "SELECT messages.*, users.businessName, users.auth, users.id, users.username  
        FROM messages
        LEFT JOIN users
        ON $join_sql = users.id
        WHERE messages.uniqueId = ?
        ORDER BY mId ASC";

        $res = $this->query($sql, [$uniqueId])->getResult();
        if(count($res)) return $res;
        return [];
    }

    public function getUnreadCount($auth) {
        $this->auth = $auth;
        $id = $this->fetchAuthID();

        $sql = "SELECT messages.* 
        FROM messages
        WHERE messages.sender = ?
        OR messages.receiver = ?
        AND viewed = 0";

        $res = $this->query($sql, [$id, $id])->getResult();
        if(count($res)) return count($res);
        return 0;
    }

    public function remove($uniqueId)
    {
        $this->query("DELETE FROM messages WHERE uniqueId = ?", [$uniqueId])->getResult();
        return true;
    }
}