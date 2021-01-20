<?php

namespace App\Models;

use Core\Model;

class Benefits extends Model
{
    public $id, $benefit = "";

    public function __construct()
    {
        parent::__construct('benefits');
    }

    public function fetchAll()
    {
        $sql = "SELECT id, benefit FROM benefits";
        $benefits = $this->query($sql)->getResult();
        if (count($benefits)) return $benefits;
        return [];
    }

    public function add()
    {
        return $this->insert(['benefit' => $this->benefit]);
    }

    public function patch($id)
    {
        return $this->update('id = ?', [$id], ['benefit' => $this->benefit]);
    }

    public function getCount() {
        $res = $this->query("SELECT * FROM benefits")->getResult();
        return count($res);
    }

    public function remove($id)
    {
        $this->query("DELETE FROM benefits WHERE id = ?", [$id]);
        return true;
    }
}