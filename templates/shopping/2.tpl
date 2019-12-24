<section id="undercolumn">
    <h2 class="title"><!--{$tpl_title|h}--></h2>

    <div id="addressBookWidgetDiv" style="height:250px"></div>
    <div id="walletWidgetDiv" style="height:250px"></div>
    <form name="form1" id="form1" method="post" action="?">
        <input type="hidden" name="<!--{$smarty.const.TRANSACTION_ID_NAME}-->" value="<!--{$transactionid}-->" />
        <input type="hidden" name="mode" value="confirm" />

        <input type="hidden" id="orderReferenceId"  name="orderReferenceId" />
        <input type="hidden" id="accessToken" name="accessToken" />

        <div class="btn_area">
            <ul class="btn_btm">
                <li id="next" style="display: none"><a rel="external" href="javascript:;" onclick="$('#form1').submit();" class="btn">お届け時間等の指定へ</a></li>
                <li>
                    <a rel="external" href="?mode=return" class="btn_back">戻る</a>
                </li>
            </ul>
        </div>
    </form>
</section>
