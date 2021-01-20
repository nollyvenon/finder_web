<?php $this->setSiteTitle('Crelance - Home') ?>

<?php $this->start('body') ?>

    <div class="oflow-hidden mb-15 mb-xs-0">
        <h4 class="float-l mb-15 lh-45 lh-xs-40">Slides</h4>
        <?php if($this->count < 5) { ?>
            <h6 class="float-r mb-15">
                <b><a class="c-btn" href="<?= PROOT ?>slide/form">+ Add Slide</a></b>
            </h6>
        <?php } ?>
    </div>

    <div class="item-wrapper">
        <div class="masonry-grid four">

            <?php foreach ($this->slides as $slide) : ?>
                <div class="masonry-item">
                    <div class="item item-img">
                        <div class="item-inner">

                            <h6 class="image-wrapper p-35" href="#">
                                <img src="<?= PROOT ?>public/images/slide/<?= $slide->image ?>" alt="image" />
                            </h6>

                            <div class="img-header action-btn-wrapper">
                                <div class="action-btn-inner">
                                    <a href="<?= PROOT ?>slide/form/<?= $slide->id ?>"><i class="ion-compose"></i></a>
                                    <a href="<?= PROOT ?>slide/remove/<?= $slide->id ?>" 
                                        data-confirm="Are you sure you want to delete this item?">
                                        <i class="ion-trash-a"></i>
                                    </a>
                                </div>
                                <!--action-btn-inner-->
                            </div>
                            <!--action-btn-wrapper-->

                        </div>
                        <!--item-inner-->
                    </div>
                    <!--item-->
                </div>
            <!--masonry-item category-item-->
            <?php endforeach ?>

        </div>
        <!--masonry-grid-->
    </div>
    <!--item-wrapper-->

    <?php //echo $pagination->format(); ?>

<?php $this->end() ?>