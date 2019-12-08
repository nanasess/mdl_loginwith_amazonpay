<?php $AmznPayHelper = new SC_Helper_AmazonPay(); ?>
<script type='text/javascript'>
 window.onAmazonLoginReady = function() {
     amazon.Login.setClientId('<?php echo $AmznPayHelper->getClientId(); ?>');
 };
 window.onAmazonPaymentsReady = function() {
     if (document.querySelector('#AmazonPayButton')) {
         showButton();
     }
     if (document.querySelector('#addressBookWidgetDiv')) {
         showAddressBookWidget();
     }
 };
</script>

<script async="async" src='<?php echo $AmznPayHelper->getWidgetsUrl(); ?>'></script>
