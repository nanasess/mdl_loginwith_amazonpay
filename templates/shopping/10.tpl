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

      <input type="hidden" id="orderReferenceId"  name="orderReferenceId" />
      <input type="hidden" id="accessToken" name="accessToken" />
      <div class="btn_area">
          <ul>
              <li>
                  <a href="?mode=return">
                      <img class="hover_change_image" src="<!--{$TPL_URLPATH}-->img/button/btn_back.jpg" alt="戻る" border="0" name="back03" id="back03" /></a>
              </li>
              <li>
                  <input type="image" class="hover_change_image" src="<!--{$TPL_URLPATH}-->img/button/btn_next.jpg" alt="次へ" name="next" id="next" style="display: none" />
              </li>
          </ul>
      </div>
  </form>
