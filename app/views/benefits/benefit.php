<?php $this->setSiteTitle('Crelance - Home') ?>

<?php $this->start('body') ?>

<div class="oflow-hidden mb-15 mb-xs-0">
    <h4 class="float-l mb-15 lh-45 lh-xs-40">Benefits</h4>
    <?php if ($this->count < 3) { ?>
        <h6 class="float-r mb-15">
            <b><a class="c-btn" href="<?= PROOT ?>benefit/form">+ Add Benefit</a></b>
        </h6>
    <?php } ?>
</div>

<div class="item-wrapper">
    <div class="masonry-grid four">

        <?php foreach ($this->benefits as $benefit) : ?>
            <div class="masonry-item">

                <h5 style="margin-top: 15px;"><?= $benefit->benefit ?></h5>
                <div class="img-header action-btn-wrapper">
                    <a href="<?= PROOT ?>benefit/form/<?= $benefit->id ?>"><i class="ion-compose"></i></a>
                    <a href="<?= PROOT ?>benefit/remove/<?= $benefit->id ?>" data-confirm="Are you sure you want to delete this item?">
                        <i class="ion-trash-a"></i>
                    </a>
                    <!--action-btn-inner-->
                </div>
                <!--action-btn-wrapper-->

            </div>
            <b>
                <!--masonry-item category-item-->
            <?php endforeach ?>

    </div>
    <!--masonry-grid-->
</div>
<!--item-wrapper-->

<?php $this->end() ?>