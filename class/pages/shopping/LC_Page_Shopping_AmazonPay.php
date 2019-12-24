<?php

class LC_Page_Shopping_AmazonPay extends LC_Page_Cart_Ex
{
    /** @var string */
    public $tpl_merchant_id;
    /** @var SC_Helper_AmazonPay */
    private $objAmzn;
    /** @var array */
    protected $vars;

    /**
     * Page を初期化する.
     *
     * @return void
     */
    public function init()
    {
        parent::init();
        $this->tpl_title = 'お支払方法・お届け先等の指定';
        $masterData = new SC_DB_MasterData_Ex();
        $this->arrPref = $masterData->getMasterData('mtb_pref');
        $this->tpl_mainpage = DATA_REALDIR.'vendor/nanasess/mdl_loginwith_amazonpay/templates/shopping/amazonpay.tpl';
        $this->objAmzn = new SC_Helper_AmazonPay();
        $this->tpl_merchant_id = $this->objAmzn->getMerchantId();
    }

    /**
     * Page のプロセス.
     *
     * @return void
     */
    public function process()
    {
        parent::process();
        $this->action();
        $this->sendResponse();
    }

    public function action()
    {
        $objCartSess = new SC_CartSession_Ex();
        $objPurchase = new SC_Helper_Purchase_Ex();
        $objSiteSess = new SC_SiteSession_Ex();

        $cartKey = $objCartSess->getKey();
        if (isset($_COOKIE['eccube_cart_key'])) {
            $cartKey = $_COOKIE['eccube_cart_key'];
        }
        // // カート内商品のチェック
        $this->tpl_message = $objCartSess->checkProducts($cartKey);
        if (!SC_Utils_Ex::isBlank($this->tpl_message)) {
            SC_Response_Ex::sendRedirect(CART_URL);
            SC_Response_Ex::actionExit();
        }

        switch ($this->getMode()) {
            case 'return':
                $objSiteSess->setRegistFlag();
                SC_Response_Ex::sendRedirect(CART_URL);
                SC_Response_Ex::actionExit();
                break;

            case 'confirm':
                $cartList = $objCartSess->getCartList($cartKey);
                // 商品が存在しない場合
                if (count($cartList) < 1) {
                    GC_Utils_Ex::gfPrintLog('Get cartlist is empty. Redirect to cart.');
                    SC_Response_Ex::sendRedirect(CART_URL);
                    SC_Response_Ex::actionExit();
                }
                // カートを購入モードに設定
                $this->lfSetCurrentCart($objSiteSess, $objCartSess, $cartKey);
                // FIXME
                $accessToken = $_POST['accessToken'];
                $orderReferenceId = $_POST['orderReferenceId'];
                /** @var AmazonPay\Client $client */
                $client = $this->objAmzn->getClient();

                /** @var AmazonPay\ResponseParser $response */
                $response = $client->getOrderReferenceDetails(
                    [
                        'merchant_id' => $this->objAmzn->getMerchantId(),
                        'amazon_order_reference_id' => $orderReferenceId,
                        'access_token' => $accessToken
                    ]
                );
                $arrValues = SC_Helper_AmazonPayConverter::orderReferenceDetailsResultToArrayOfOrder(
                    $response->toArray()
                );
                $arrOrder = [];
                $objPurchase->copyFromOrder($arrOrder, $arrValues, 'order', '');

                // UserInfo に一致する Customer が存在する場合はログインする
                $userInfo = $client->getUserInfo($accessToken);
                if ($this->doLoginWithAmazon($userInfo, $accessToken)) {
                    $objCustomer = new SC_Customer_Ex();
                    $objPurchase->copyFromCustomer($arrOrder, $objCustomer);
                }

                $arrShippings = [];
                $objPurchase->copyFromOrder($arrShippings, $arrValues, 'shipping', '');
                $arrOrder['memo04'] = $accessToken;
                $arrOrder['memo05'] = $orderReferenceId;
                $arrOrder['memo06'] = $userInfo['user_id'];
                $arrOrder['order_name01'] = $userInfo['name'];
                $arrOrder['order_email'] = $userInfo['email'];

                $arrOrder['payment_id'] = SC_Helper_AmazonPay::PAYMENT_ID;
                $arrOrder['payment_method'] = 'Amazon Pay';

                $objPurchase->saveShippingTemp($arrShippings);

                $objPurchase->saveOrderTemp($objSiteSess->getUniqId(), $arrOrder);

                $objSiteSess->setRegistFlag();

                // 確認ページへ移動
                SC_Response_Ex::sendRedirect(SHOPPING_PAYMENT_URLPATH);
                SC_Response_Ex::actionExit();
                break;
        }
    }

    public function setVars(array $vars)
    {
        $this->vars = $vars;
    }

    protected function doLoginWithAmazon(array $userInfo, $accessToken, $expires_in = 3600, $scope = 'profile payments:widget payments:shipping_address')
    {
        $objClient = SC_Helper_OAuth2::getOAuth2Client(OAuth2Client::AMAZON);
        $objQuery = SC_Query_Ex::getSingletonInstance();
        $arrCustomer = $objQuery->getRow('*', 'dtb_customer',
                                         'customer_id = (SELECT customer_id FROM dtb_oauth2_openid_userinfo WHERE oauth2_client_id = ? AND sub = ?)',
                                         [$objClient->oauth2_client_id, $userInfo['user_id']]);
        if (SC_Utils_Ex::isBlank($arrCustomer)) {
            GC_Utils_Ex::gfPrintLog('Customer が存在しませんでした');

            return false;
        }

        GC_Utils_Ex::gfPrintLog('Customer が存在するためログインします customer_id='.$arrCustomer['customer_id']);
        // login
        $objCustomer = new SC_Customer_Ex();
        $objCustomer->setLogin($arrCustomer['email']);
        $objCustomer->setOAuth2ClientId($objClient->oauth2_client_id);
        $userInfo['oauth2_client_id'] = $objClient->oauth2_client_id;
        $userInfo['sub'] = $userInfo['user_id'];
        $userInfo['customer_id'] = $arrCustomer['customer_id'];
        $token = [
            'oauth2_client_id' => $objClient->oauth2_client_id,
            'customer_id' => $arrCustomer['customer_id'],
            'access_token' => $accessToken,
            'scope' => $scope,
            'expires_in' => $expires_in
        ];
        SC_Helper_OAuth2::registerToken($token);
        SC_Helper_OAuth2::registerUserInfo($userInfo);
        return true;
    }
}
