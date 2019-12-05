<?php $AmznPayHelper = new SC_Helper_AmazonPay(); ?>
<script type='text/javascript'>
 window.onAmazonLoginReady = function() {
     amazon.Login.setClientId('<?php echo $AmznPayHelper->getClientId(); ?>');
 };
 window.onAmazonPaymentsReady = function() {
     showButton();
 };
</script>

<script async="async" src='<?php echo $AmznPayHelper->getWidgetsUrl(); ?>'></script>
