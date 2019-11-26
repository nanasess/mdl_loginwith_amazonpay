<?php

class SC_Helper_AmazonPay
{
    /** @var string */
    private $marchant_id;
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
        $this->sandbox = (bool) $sandbox ? $sandbox : getenv('AMZN_SANDBOX');
    }
}
