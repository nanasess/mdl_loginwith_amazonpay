<div id="undercolumn">
    <div id="undercolumn_shopping">
        <p class="flow_area">
            <img src="<!--{$TPL_URLPATH}-->img/picture/img_flow_02.jpg" alt="購入手続きの流れ" />
        </p>
        <h1 class="title"><!--{$tpl_title|h}--></h1>

  <div id="addressBookWidgetDiv" style="height:250px"></div>
  <div id="walletWidgetDiv" style="height:250px"></div>
  <form name="form1" id="form1" method="post" action="?">
      <input type="hidden" name="<!--{$smarty.const.TRANSACTION_ID_NAME}-->" value="<!--{$transactionid}-->" />
      <input type="hidden" name="mode" value="confirm" />

      <input type="text" id="orderReferenceId"  name="orderReferenceId" />
      <input type="text" id="accessToken" name="accessToken" />
      <div class="btn_area">
          <ul>
              <li>
                  <a href="?mode=return">
                      <img class="hover_change_image" src="<!--{$TPL_URLPATH}-->img/button/btn_back.jpg" alt="戻る" border="0" name="back03" id="back03" /></a>
              </li>
              <li>
                  <input type="image" class="hover_change_image" src="<!--{$TPL_URLPATH}-->img/button/btn_next.jpg" alt="次へ" name="next" id="next" />
              </li>
          </ul>
      </div>
  </form>

<script>
 function showAddressBookWidget() {
    new OffAmazonPayments.Widgets.AddressBook({
    sellerId: '<!--{$tpl_merchant_id|h}-->',
    onOrderReferenceCreate: function(orderReference) {
        // Here is where you can grab the Order Reference ID.
        orderReference.getAmazonOrderReferenceId();
    },
    onAddressSelect: function(orderReference) {
        // Replace the following code with the action that you want
        // to perform after the address is selected. The
        // amazonOrderReferenceId can be used to retrieve the address
        // details by calling the GetOrderReferenceDetails operation.
        // If rendering the AddressBook and Wallet widgets
        // on the same page, you do not have to provide any additional
        // logic to load the Wallet widget after the AddressBook widget.
        // The Wallet widget will re-render itself on all subsequent
        // onAddressSelect events, without any action from you.
        // It is not recommended that you explicitly refresh it.
        console.log(orderReference);
    },
    design: {
        designMode: 'responsive'
    },
    onReady: function(orderReference) {
        var orderReferenceId = orderReference.getAmazonOrderReferenceId();
              var el;
              if ((el = document.getElementById("orderReferenceId"))) {
                el.value = orderReferenceId;
              }
              // Wallet
              showWalletWidget(orderReferenceId);
    },
    onError: function(error) {
        // Your error handling code.
        // During development you can use the following
        // code to view error messages:
        // console.log(error.getErrorCode() + ': ' + error.getErrorMessage());
        // See "Handling Errors" for more information.
    }
    }).bind("addressBookWidgetDiv");
 }

 function showWalletWidget(orderReferenceId) {
        // Wallet
        new OffAmazonPayments.Widgets.Wallet({
          sellerId: '<!--{$tpl_merchant_id|h}-->',
          amazonOrderReferenceId: orderReferenceId,
          onReady: function(orderReference) {
              console.log(orderReference.getAmazonOrderReferenceId());
          },
          onPaymentSelect: function() {
              console.log(arguments);
          },
          design: {
              designMode: 'responsive'
          },
          onError: function(error) {
              // エラー処理 
              // エラーが発生した際にonErrorハンドラーを使って処理することをお勧めします。 
              // @see https://payments.amazon.com/documentation/lpwa/201954960
              console.log('OffAmazonPayments.Widgets.Wallet', error.getErrorCode(), error.getErrorMessage());
          }
        }).bind("walletWidgetDiv");
    }
</script>

    </div>
</div>
