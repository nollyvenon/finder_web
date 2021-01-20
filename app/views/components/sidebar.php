<?php

$index = $category = $ad = $user = $find = $slide = $benefit = "";


if($this->current == "index" || $this->current == "home") $index = "active";
else if(($this->current == "category") || ($this->current == "form.php")) $category = "active";
else if($this->current == "ad") $ad = "active";
else if($this->current == "find") $find = "active";
else if($this->current == "user") $user = "active";
else if(($this->current == "slide") || ($this->current == "form.php")) $slide = "active";
else if(($this->current == "benefit") || ($this->current == "form.php")) $benefit = "active";

?>

<div class="sidebar">
    <ul class="sidebar-list">
        <li class="<?= $index; ?>">
            <a href="<?= PROOT ?>home"><i class="ion-ios-pie"></i><span>Dashboard</span></a>
        </li>
        <li class="<?= $category; ?>">
            <a href="<?= PROOT ?>category/cat"><i class="ion-social-buffer"></i><span>Categories</span></a>
        </li>
        <li class="<?= $find; ?>">
            <a href="<?= PROOT ?>find/f/0"><i class="ion-android-laptop"></i><span>Finds</span></a>
        </li>
        <li class="<?= $ad; ?>">
            <a href="<?= PROOT ?>ad/a/0"><i class="ion-android-film"></i><span>Ads</span></a>
        </li>
        <li class="<?= $user; ?>"><a href="<?= PROOT ?>user/u/0"><i class="ion-person"></i><span>Register Users</span></a></li>
        <li class="<?= $slide; ?>"><a href="<?= PROOT ?>slide"><i class="ion-cash"></i><span>Slide</span></a></li>
        <li class="<?= $benefit; ?>">
            <a href="<?= PROOT ?>benefit"><i class="ion-social-buffer"></i><span>Benefits</span></a>
        </li>
    </ul>
</div><!--sidebar-->