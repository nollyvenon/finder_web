<?php 
    use Core\CSRF;
    $this->setSiteTitle('Intscribe - Login') 
?>

<?php $this->start('body') ?>

    <div class="dplay-tbl">
        <div class="dplay-tbl-cell">
            <div class="item-wrapper one pb-100">
                <div class="item">
                    <div class="item-inner">
                        <h4 class="item-header">Login</h4>
                        <div class="item-content">
                            <form data-validation="true" action="<?= PROOT ?>login" method="post">

                                <label>Username</label>
                                <input data-required="true" type="text" class="form-control" name="username"
                                    value="<?php $this->user == null ? "" : $this->user->username; ?>" placeholder="Username">

                                <label>Password</label>
                                <input data-required="true" type="password" class="form-control" name="password"
                                    value="<?php $this->user == null ? "" : $this->user->password; ?>" placeholder="Password">

                                <div class="btn-wrapper"><button type="submit" class="c-btn mb-10"><b>Login</b></button>
                                </div>

                            </form>
                        </div>
                        <!--item-content-->
                    </div>
                    <!--item-inner-->
                </div>
                <!--item-->
            </div>
            <!--item-wrapper-->
        </div>
        <!--dplay-tbl-cell-->
    </div><!-- dplay-tbl -->

<?php $this->end() ?>