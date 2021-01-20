<?php

namespace App\Models;

use Core\Model;
use Core\Resize;

class Slides extends Model
{
    public $id, $image = "";

    public function __construct()
    {
        parent::__construct('slides');
    }

    public function fetchAll()
    {
        $sql = "SELECT id, `image` FROM slides";
        $slides = $this->query($sql)->getResult();
        if (count($slides)) return $slides;
        return [];
    }

    public function add()
    {
        return $this->insert(['image' => $this->image]);
    }

    public function patch($id)
    {
        return $this->update('id = ?', [$id], ['image' => $this->image]);
    }

    public function uploadImage($old_image = "", $id = 0) {
        $resize = new Resize();
        
        $image = $_FILES["image"]["name"];
        $ext = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
        $image = $this->image = time().random_int(100, 1000000000).".".$ext;

        if($id != 0) $this->update('id = ?', [$id], ['image' => $image]);

        //The old logo is deleted if it exists
        if(!empty($old_image)) unlink(ROOT . DS . 'public' . DS . 'images' . DS . 'slide' . DS . $old_image);

        $resize::changeSize(//temporary image image location
            $_FILES["image"]["tmp_name"], 
            //location to upload resized image
            ROOT . DS . 'public' . DS . 'images' . DS . 'slide' . DS . $image,
            //Maximum width of the new resized image
            800, 
            //Maximum height of the new resized image
            800,
            //File extension of the new resized image
            $ext,
            //Quality of the image
            85 );
        return true;
    }

    public function getCount() {
        $res = $this->query("SELECT * FROM slides")->getResult();
        return count($res);
    }

    public function remove($id)
    {
        $this->query("DELETE FROM slides WHERE id = ?", [$id]);
        return true;
    }
}