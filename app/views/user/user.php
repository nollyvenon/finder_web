<?php

$this->setSiteTitle("Users") ?>

<?php $this->start('body') ?>
    <table class="a-table">
        <thead>
            <tr>
                <td>Username</td>
                <td>Location</td> 
                <td>Business Name</td>
                <td>Business Description</td>
                <td>Verified Tel</td>
                <td>Account Number</td>
                <td>Service Description</td>
                <td>rating</td>
                <td>Time Posted</td>
            </tr>
        </thead>		 	  	 	
  	 
        <tbody>
            <?php foreach($this->users as $user) : ?>
                <tr>
                    <td><?= $user->username ?></td>
                    <td><?= $user->location ?></td>
                    <td><?= $user->businessName ?></td>
                    <td><?= $user->businessDescription ?></td>
                    <td><?= $user->verifiedPhoneNumber ?></td>

                    <td><?= $user->accountNumber ?></td>
                    <td><?= $user->serviceDescription ?></td>
                    <td><?= $user->rating ?></td>

                    <td><?= $user->createdAt ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>

    <ul class="pagination" style="text-align: center;">
        <?php if($this->current_page > 1 || $this->has_next) { ?>
            <li>
                <a href="<?= PROOT ?>user/u/0 ?>"><i class="ion-ios-arrow-left"></i><i class="ion-ios-arrow-left"></i></a>
            </li>
        <?php } else { ?>
            <li class="disable"><i class="ion-ios-arrow-left"></i><i class="ion-ios-arrow-left"></i></li>
        <?php } ?>

        <li><a href="<?= PROOT ?>user/u/0">1</a></li>

        <?php if($this->has_next) : ?>
            <?php for($i = 2; $i <= $this->current_page; $i++) : ?>
                <li>
                    <a href="<?= PROOT ?>user/u/<?= $this->current_page ?>"><?= $i ?></a>
                </li>
            <?php endfor ?>
        <?php endif ?>

        <?php if($this->has_next) { ?>
            <li>
                <a href="<?= PROOT ?>user/u/<?= $this->current_page  ?>">
                    <i class="ion-ios-arrow-right"></i><i class="ion-ios-arrow-right"></i>
                </a>
            </li>
        <?php } else { ?>
            <li class="disable"><i class="ion-ios-arrow-right"></i><i class="ion-ios-arrow-right"></i></li>
        <?php } ?>
    </ul>

<?php $this->end() ?>