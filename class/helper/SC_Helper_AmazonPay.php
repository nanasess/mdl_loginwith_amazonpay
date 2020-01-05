<?php

class SC_Helper_AmazonPay
{
    /** @var string */
    const MWS_ENDPOINT_URL = 'https://mws.amazonservices.jp/OffAmazonPayments/2013-01-01/';
    /** @var string */
    const SANDBOX_MWS_ENDPOINT_URL = 'https://mws.amazonservices.jp/OffAmazonPayments/2013-01-01/';
    /** @var string */
    const SANDBOX_WIDGETS_URL = 'https://static-fe.payments-amazon.com/OffAmazonPayments/jp/sandbox/lpa/js/Widgets.js';
    /** @var string */
    const WIDGETS_URL = 'https://static-fe.payments-amazon.com/OffAmazonPayments/jp/lpa/js/Widgets.js';
    /** @var string */
    const SANDBOX_PROFILE_ENDPOINT_URL = 'https://api-sandbox.amazon.co.jp/user/profile';
    /** @var string */
    const PROFILE_ENDPOINT_URL = 'https://api.amazon.co.jp/user/profile';
    /** @var int */
    const PAYMENT_ID = 999999;
    /** @var string */
    const MODULE_CODE = 'mdl_loginwith_amazonpay';

    /** @var string */
    private $merchant_id;
    /** @var string */
    private $access_key;
    /** @var string */
    private $secret_key;
    /** @var string */
    private $client_id;
    /** @var string */
    private $region;
    /** @var bool */
    private $sandbox;

    /**
     * @param string $merchant_id
     * @param string $access_key
     * @param string $secret_key
     * @param string $client_id
     * @param string $region
     * @param bool $sandbox
     */
    public function __construct($merchant_id = null, $access_key = null, $secret_key = null, $client_id = null, $region = null, $sandbox = false)
    {
        $this->merchant_id = $merchant_id ? $merchant_id : getenv('AMZN_MERCHANT_ID');
        $this->access_key = $access_key ? $access_key : getenv('AMZN_ACCESS_KEY');
        $this->secret_key = $secret_key ? $secret_key : getenv('AMZN_SECRET_KEY');
        $this->client_id = $client_id ? $client_id : getenv('AMZN_CLIENT_ID');
        $this->region = $region ? $region : getenv('AMZN_REGION');
        $this->sandbox = (bool) ($sandbox ? $sandbox : getenv('AMZN_SANDBOX'));
    }

    /**
     * @return AmazonPay\ClientInterface
     */
    public function getClient()
    {
        $config = [
            'merchant_id' => $this->merchant_id,
            'access_key' => $this->access_key,
            'secret_key' => $this->secret_key,
            'client_id' => $this->client_id,
            'region' => $this->region,
            'sandbox' => $this->sandbox
        ];

        return new AmazonPay\Client($config);
    }

    /**
     * @return bool
     */
    public function useSandbox()
    {
        return $this->sandbox;
    }

    public function getClientId()
    {
        return $this->client_id;
    }

    public function getMerchantId()
    {
        return $this->merchant_id;
    }

    /**
     * @return string
     */
    public function getMwsEndpointUrl()
    {
        if ($this->useSandbox()) {
            return getenv('AMZN_SANDBOX_MWS_ENDPOINT_URL') ? getenv('AMZN_SANDBOX_MWS_ENDPOINT_URL') : self::SANDBOX_MWS_ENDPOINT_URL;
        }

        return getenv('AMZN_MWS_ENDPOINT_URL') ? getenv('AMZN_MWS_ENDPOINT_URL') : self::MWS_ENDPOINT_URL;
    }

    /**
     * @return string
     */
    public function getWidgetsUrl()
    {
        if ($this->useSandbox()) {
            return getenv('AMZN_SANDBOX_WIDGETS_URL') ? getenv('AMZN_SANDBOX_WIDGETS_URL') : self::SANDBOX_WIDGETS_URL;
        }

        return getenv('AMZN_WIDGETS_URL') ? getenv('AMZN_WIDGETS_URL') : self::WIDGETS_URL;
    }

    /**
     * @return string
     */
    public function getProfileEndpointUrl()
    {
        if ($this->useSandbox()) {
            return getenv('AMZN_SANDBOX_PROFILE_ENDPOINT_URL') ? getenv('AMZN_SANDBOX_PROFILE_ENDPOINT_URL') : self::SANDBOX_PROFILE_ENDPOINT_URL;
        }

        return getenv('AMZN_PROFILE_ENDPOINT_URL') ? getenv('AMZN_PROFILE_ENDPOINT_URL') : self::PROFILE_ENDPOINT_URL;
    }
}
