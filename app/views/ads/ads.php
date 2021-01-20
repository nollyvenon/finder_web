<?php $this->setSiteTitle('Crelance - Ads') ?>

<?php $this->start('body') ?>

    <table class="a-table">
        <thead>
            <tr>
                <td>Title</td>
                <td>Description</td>
                <td>Promotions</td>
                <td>Price</td>
                <td>Time Posted</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach($this->ads as $ad) : ?>
                <tr>
                    <td><?= $ad->title ?></td>
                    <td><?= $ad->description ?></td>
                    <td><?= $ad->benefit ?></td>

                    <td><?= $ad->price ?></td>

                    <td><?= $ad->createdAt ?></td>
                    <td>
                        <a href="<?= PROOT ?>ad/a/0">
                            <button>Delete</button> 
                        </a>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>

    <ul class="pagination" style="text-align: center;">
        <?php if($this->current_page > 1 || $this->has_next) { ?>
            <li>
                <a href="<?= PROOT ?>ad/a/0 ?>"><i class="ion-ios-arrow-left"></i><i class="ion-ios-arrow-left"></i></a>
            </li>
        <?php } else { ?>
            <li class="disable"><i class="ion-ios-arrow-left"></i><i class="ion-ios-arrow-left"></i></li>
        <?php } ?>

        <li><a href="<?= PROOT ?>ad/a/0">1</a></li>

        <?php if($this->has_next) : ?>
            <?php for($i = 2; $i <= $this->current_page; $i++) : ?>
                <li>
                    <a href="<?= PROOT ?>ad/a/<?= $this->current_page ?>"><?= $i ?></a>
                </li>
            <?php endfor ?>
        <?php endif ?>

        <?php if($this->has_next) { ?>
            <li>
                <a href="<?= PROOT ?>ad/a/<?= $this->current_page  ?>">
                    <i class="ion-ios-arrow-right"></i><i class="ion-ios-arrow-right"></i>
                </a>
            </li>
        <?php } else { ?>
            <li class="disable"><i class="ion-ios-arrow-right"></i><i class="ion-ios-arrow-right"></i></li>
        <?php } ?>
    </ul>

<?php $this->end() ?>