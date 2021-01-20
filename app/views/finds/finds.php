<?php $this->setSiteTitle('Crelance - Finds') ?>

<?php $this->start('body') ?>

    <table class="a-table">
        <thead>
            <tr>
                <td>Title</td> 
                <td>Description</td>
                <td>Category</td>
                <td>Promotions</td>
                <td>Price</td>
                <td>Proposal</td>
                <td>Time Posted</td>
            </tr>
        </thead>
        <tbody>
            <?php foreach($this->finds as $find) : ?>
                <tr>
                    <td><?= $find->title ?></td>
                    <td><?= $find->description ?></td>
                    <td><?= $find->category ?></td>
                    <td><?= $find->benefit ?></td>

                    <td><?= $find->price ?></td>
                    <td><?= $find->proposals ?></td>

                    <td><?= $find->createdAt ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>

    <ul class="pagination" style="text-align: center;">
        <?php if($this->current_page > 1 || $this->has_next) { ?>
            <li>
                <a href="<?= PROOT ?>find/f/0 ?>"><i class="ion-ios-arrow-left"></i><i class="ion-ios-arrow-left"></i></a>
            </li>
        <?php } else { ?>
            <li class="disable"><i class="ion-ios-arrow-left"></i><i class="ion-ios-arrow-left"></i></li>
        <?php } ?>

        <li><a href="<?= PROOT ?>find/f/0">1</a></li>

        <?php if($this->has_next) : ?>
            <?php for($i = 2; $i <= $this->current_page; $i++) : ?>
                <li>
                    <a href="<?= PROOT ?>find/f/<?= $this->current_page ?>"><?= $i ?></a>
                </li>
            <?php endfor ?>
        <?php endif ?>

        <?php if($this->has_next) { ?>
            <li>
                <a href="<?= PROOT ?>find/f/<?= $this->current_page  ?>">
                    <i class="ion-ios-arrow-right"></i><i class="ion-ios-arrow-right"></i>
                </a>
            </li>
        <?php } else { ?>
            <li class="disable"><i class="ion-ios-arrow-right"></i><i class="ion-ios-arrow-right"></i></li>
        <?php } ?>
    </ul>

<?php $this->end() ?>