<?php

use Core\CSRF;

$this->setSiteTitle('Nairafill - Payment') ?>

<?php $this->start('body') ?>
<section>
    <form>
        <h3>Transfer using paystack</h3>
        <script src="https://js.paystack.co/v1/inline.js"></script>
        <!-- <button type="button" onclick="payWithPaystack()"> Pay </button> -->
    </form>

</section>

<script>
    window.addEventListener("DOMContentLoaded", payWithPaystack)

    function payWithPaystack() {
        var handler = PaystackPop.setup({
            key: 'pk_test_564016ad5c85950dbb2af2e6a14957faa89adb28',
            email: '<?= $this->user->email ?>',
            amount: 10000,
            ref: '' + Math.floor((Math.random() * 1000000000) + 1), // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
            metadata: {
                custom_fields: [{
                    display_name: "<?= $this->user->businessName ?>",
                    variable_name: "mobile_number",
                    value: "<?= $this->user->verifiedPhoneNumber ?>"
                }]
            },
            callback: function(response) {
                fetch(`crelance.onyxdatasystems.com/users/setPremium/<?= $this->user->auth ?>/1`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.status === true) {
                            store.getState().columnOne.details.post_count = data.post_count;
                            document.querySelector("#post" + postID).style.display = "none";
                        }
                    });
                alert('success. transaction ref is ' + response.reference);
            },
            onClose: function() {
                alert('window closed');
            }
        });
        handler.openIframe();
    }
</script>

<?php $this->end() ?>