<?php $AmznPayHelper = new SC_Helper_AmazonPay(); ?>
<script type='text/javascript'>
 window.onAmazonLoginReady = function() {
     amazon.Login.setClientId('<?php echo $AmznPayHelper->getClientId(); ?>');
 };
 window.onAmazonPaymentsReady = function() {
     var lists = document.querySelectorAll('[id^=AmazonPayButton]');
     if (lists) {
         var nodes = Array.prototype.slice.call(lists, 0);
         nodes.forEach(function(el, index) {
             showButton(el.id.replace('AmazonPayButton', ''));
         });
     }
     if (document.querySelector('#addressBookWidgetDiv')) {
         showAddressBookWidget();
     }
 };
</script>

<script async="async" src='<?php echo $AmznPayHelper->getWidgetsUrl(); ?>'></script>
