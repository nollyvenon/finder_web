<?php $this->setSiteTitle('Crelance - Home') ?>

<?php $this->start('body') ?>

    <div class="item-wrapper three">

        <div class="item item-dahboard">
            <div class="item-inner">
                
                <div class="item-content">
                    <h2 class="title"><b><?= $this->user_count ?></b></h2>
                    <h4 class="desc">Users</h4>
                </div>
                <!--item-content-->

                <div class="icon"><i class="ion-android-people"></i></div>

                <div class="item-footer">
                    <a href="<?= PROOT ?>user/u/0">More info <i class="ml-10 ion-chevron-right"></i><i
                            class="ion-chevron-right"></i></a>
                </div>
                <!--item-footer-->

            </div>
            <!--item-inner-->
        </div>
        <!--item-->


        <div class="item item-dahboard">
            <div class="item-inner">
                <div class="item-content">
                    <h2 class="title"><b><?= $this->find_count ?></b></h2>
                    <h4 class="desc">Finds</h4>
                </div>
                <div class="icon"><i class="ion-ios-download"></i></div>
                <div class="item-footer">
                    <a href="<?= PROOT ?>find/f/0">More info <i class="ml-10 ion-chevron-right"></i><i
                            class="ion-chevron-right"></i></a>
                </div>
                <!--item-footer-->
            </div>
            <!--item-inner-->
        </div>
        <!--item-->

        <div class="item item-dahboard">
            <div class="item-inner">
                <div class="item-content">
                    <h2 class="title"><b><?= $this->ad_count ?></b></h2>
                    <h4 class="desc">Ads</h4>
                </div>
                <div class="icon"><i class="ion-social-buffer"></i></div>
                <div class="item-footer">
                    <a href="<?= PROOT ?>ads/a/0">More info <i class="ml-10 ion-chevron-right"></i><i
                            class="ion-chevron-right"></i></a>
                </div>
                <!--item-footer-->
            </div>
            <!--item-inner-->
        </div>
        <!--item-->

        <div class="item item-dahboard">
            <div class="item-inner">
                <div class="item-content">
                    <h2 class="title"><b><?= $this->category_count ?></b></h2>
                    <h4 class="desc">Categories</h4>
                </div>
                <div class="icon"><i class="ion-social-buffer"></i></div>
                <div class="item-footer">
                    <a href="<?= PROOT ?>category/cat">More info <i class="ml-10 ion-chevron-right"></i><i
                            class="ion-chevron-right"></i></a>
                </div>
                <!--item-footer-->
            </div>
            <!--item-inner-->
        </div>
        <!--item-->

        <div class="item item-dahboard">
            <div class="item-inner">
                <div class="item-content">
                    <h2 class="title"><b><?= $this->slide_count ?></b></h2>
                    <h4 class="desc">Slides</h4>
                </div>
                <div class="icon"><i class="ion-android-laptop"></i></div>

                <div class="item-footer">
                    <a href="<?= PROOT ?>slide">More info <i class="ml-10 ion-chevron-right"></i><i
                            class="ion-chevron-right"></i></a>
                </div>
                <!--item-footer-->

            </div>
            <!--item-inner-->
        </div>
        <!--item-->

        <div class="item item-dahboard">
            <div class="item-inner">
                <div class="item-content">
                    <h2 class="title"><b><?= $this->benefit_count ?></b></h2>
                    <h4 class="desc">Benefits</h4>
                </div>
                <div class="icon"><i class="ion-social-buffer"></i></div>

                <div class="item-footer">
                    <a href="<?= PROOT ?>benefit">More info <i class="ml-10 ion-chevron-right"></i><i
                            class="ion-chevron-right"></i></a>
                </div>
                <!--item-footer-->

            </div>
            <!--item-inner-->
        </div>
        <!--item-->

    </div>
    <!--item-wrapper-->

<?php $this->end() ?>