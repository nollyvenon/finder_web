<?php $this->setSiteTitle('Crelance - Home') ?>

<?php $this->start('body') ?>

    <div class="item-wrapper one">
        <div class="item">

            <form data-validation="true" action="<?= PROOT ?>/benefit/form/<?= $this->benefit->id ?>" method="post"
                enctype="multipart/form-data">

                <div class="item-inner">

                    <div class="item-header">
                        <h5 class="dplay-inl-b">Benefit</h5>
                    </div>
                    <!--item-header-->

                    <div class="item-content">
                        <input type="hidden" name="id" value="<?= $this->benefit != null ? $this->benefit->id : ""; ?>">

                        <label class="control-label" for="file">Benefit</label>
                        <div class="upload">
                            <input data-required="benefit" type="text" name="benefit" class="text-input"
                                value="<?= $this->benefit != null ? $this->benefit->benefit : ""; ?>" />
                        </div>

                        <div class="btn-wrapper"><button type="submit" class="c-btn mb-10"><b>Save</b></button>
                        </div>
                    </div>

                    </div>
                    <!--item-content-->
                </div>
                <!--item-inner-->

            </form>
        </div>
        <!--item-->
    </div>
    <!--item-wrapper-->

<?php $this->end() ?>