<?php $AmznPayHelper = new SC_Helper_AmazonPay(); ?>
<script type="text/javascript">
   function getURLParameter(name, source) {
       return decodeURIComponent((new RegExp('[?|&amp;|#]' + name + '=' +
                                             '([^&;]+?)(&|#|;|$)').exec(source) || [, ""])[1].replace(/\+/g, '%20')) || null;
    }

    var accessToken = getURLParameter("access_token", location.hash);
    if (typeof accessToken === 'string' && accessToken.match(/^Atza/)) {
        <?php if ($AmznPayHelper->useSandbox()): ?>
            document.cookie = "amazon_Login_accessToken=" + accessToken + ";path=/;";
        <?php else: ?>
            document.cookie = "amazon_Login_accessToken=" + accessToken + ";path=/;secure";
        <?php endif; ?>
        var el;
        if ((el = document.getElementById("accessToken"))) {
            el.value = accessToken;
        }
    }
 function showButton(key = '') {
     var authRequest;
     OffAmazonPayments.Button("AmazonPayButton" + key, "<?php echo $AmznPayHelper->getMerchantId(); ?>", {
         type: "PwA",
         color: "Gold",
         size: "medium",
         authorization: function() {
             <?php if ($AmznPayHelper->useSandbox()): ?>
                 document.cookie = "eccube_cart_key=" + key + ";path=/;";
             <?php else: ?>
                 document.cookie = "eccube_cart_key=" + key + ";path=/;secure";
             <?php endif; ?>
             loginOptions = {scope: "profile payments:widget payments:shipping_address", popup: false};
             authRequest = amazon.Login.authorize (loginOptions, '<?php echo HTTPS_URL; ?>shopping/amazonpay');
         }
     });
 }
</script>
