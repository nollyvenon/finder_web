<?php

namespace App\Models;

use Core\Model;
use Core\Resize;

class Category extends Model
{
    public $id, $name, $image = "";

    public function __construct()
    {
        parent::__construct('category');
    }

    public function fetchAll()
    {
        $sql = "SELECT id, `name`, `count`, `image` FROM category";
        $categories = $this->query($sql)->getResult();
        if (count($categories)) {
            return $categories;
        }
        return [];
    }

    public function fetchAllApi()
    {
        $sql = "SELECT id, `name`, `count`, `image` FROM category";
        $categories = $this->query($sql)->getResult();
        if (count($categories)) {
            return $categories;
        }
        return [];
    }

    public function add()
    {
        return $this->insert([
            'name' => $this->name,
            'image' => $this->image,
        ]);
    }

    public function patch($id)
    {
        return $this->update('id = ?', [$id], 
        [
            'name' => $this->name
        ]);
    }

    public function patchCount($id, $count)
    {
        return $this->update('id = ?', [$id], ['count' => $count]);
    }

    public function getCategoryCount($id)
    {
        $sql = "SELECT `count` FROM category WHERE id = ?";
        return $this->query($sql, [$id])->getResult()[0]->count;
    }

    public function uploadImage($old_image = "", $id = 0) { 
        $resize = new Resize();
        
        $image = $_FILES["image"]["name"];
        if($image == "") return true;

        $ext = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
        $image = $this->image = time().random_int(100, 1000000000).".".$ext;

        if($id != 0) $this->update('id = ?', [$id], ['image' => $image]);

        //The old logo is deleted if it exists
        if(!empty($old_image)) unlink(ROOT . DS . 'public' . DS . 'images' . DS . 'category' . DS . $old_image);

        $resize::changeSize(//temporary image image location
            $_FILES["image"]["tmp_name"], 
            //location to upload resized image
            ROOT . DS . 'public' . DS . 'images' . DS . 'category' . DS . $image,
            //Maximum width of the new resized image
            100, 
            //Maximum height of the new resized image
            100,
            //File extension of the new resized image
            $ext,
            //Quality of the image
            90 );
        return true;
    }

    public function fetchRecent()
    {
        $sql = "SELECT id, `name`, `count`, `image` FROM category ORDER BY count DESC LIMIT 6";
        $categories = $this->query($sql)->getResult();
        if (count($categories)) {
            return $categories;
        }
        return [];
    }
    

    public function getCount() {
        $res = $this->query("SELECT * FROM category")->getResult();
        return count($res);
    }

    public function remove($id)
    {
        $this->query("DELETE FROM category WHERE id = ?", [$id]);
        return true;
    }
}