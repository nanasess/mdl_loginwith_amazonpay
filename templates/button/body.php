<?php $AmznPayHelper = new SC_Helper_AmazonPay(); ?>
<script type="text/javascript">
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
