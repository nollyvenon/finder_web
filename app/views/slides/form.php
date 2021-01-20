<?php $this->setSiteTitle('Crelance - Home') ?>

<?php $this->start('body') ?>

    <div class="item-wrapper one">
        <div class="item">

            <form data-validation="true" action="<?= PROOT ?>/slide/form/<?= $this->slide->id; ?>" method="post"
                enctype="multipart/form-data">

                <div class="item-inner">

                    <div class="item-header">
                        <h5 class="dplay-inl-b">Slide</h5>
                    </div>
                    <!--item-header-->

                    <div class="item-content">
                        <input type="hidden" name="id" value="<?= $this->slide != null ? $this->slide->id : ""; ?>">

                        <label class="control-label" for="file">Image</label>
                        <div class="image-upload">
                            <img src="<?= PROOT ?>public/images/slide/<?php 
                                if (!empty($this->slide->image)) { echo $this->slide->image;
                            } ?>"
                                alt="" id="uploaded-image" />
                            <div class="h-100" id="upload-content">
                                <div class="dplay-tbl">
                                    <div class="dplay-tbl-cell">
                                        <i class="ion-ios-cloud-upload"></i>
                                        <h5><b>Choose Your Image to Upload</b></h5>
                                    </div>
                                </div>
                            </div>
                            <!--upload-content-->

                            <input data-required="image" type="file" name="image" class="image-input"
                                data-traget-resolution="image_resolution"
                                value="<?= $this->slide != null ? $this->slide->image : ""; ?>" />
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
    <?php echo "<script>maxUploadedFile = '" . 1.5  . "'</script>"; ?>

<?php $this->end() ?>