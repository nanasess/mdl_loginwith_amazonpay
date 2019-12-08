<?php $AmznPayHelper = new SC_Helper_AmazonPay(); ?>
<script type="text/javascript">
   function getURLParameter(name, source) {
       return decodeURIComponent((new RegExp('[?|&amp;|#]' + name + '=' +
                                             '([^&;]+?)(&|#|;|$)').exec(source) || [, ""])[1].replace(/\+/g, '%20')) || null;
    }

    var accessToken = getURLParameter("access_token", location.hash);
    if (typeof accessToken === 'string' && accessToken.match(/^Atza/)) {
        // document.cookie = "amazon_Login_accessToken=" + accessToken + ";path=/;secure";
        document.cookie = "amazon_Login_accessToken=" + accessToken + ";path=/;";
        var el;
        if ((el = document.getElementById("accessToken"))) {
            el.value = accessToken;
        }
    }
 function showButton() {
     var authRequest;
     OffAmazonPayments.Button("AmazonPayButton", "<?php echo $AmznPayHelper->getMerchantId(); ?>", {
         type: "PwA",
         color: "Gold",
         size: "medium",
         authorization: function() {
             loginOptions = {scope: "profile payments:widget payments:shipping_address", popup: false};
             authRequest = amazon.Login.authorize (loginOptions, '<?php echo HTTPS_URL; ?>shopping/amazonpay');
         }
     });
 }
</script>
