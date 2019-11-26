<?php

use PHPUnit\Framework\TestCase;

class SC_Helper_AmazonPayTest extends TestCase
{
    public function testGetInstance()
    {
        $merchant_id = 'merchant_id';
        $access_key = 'access_key';
        $secret_key = 'secret_key';
        $client_id = 'client_id';
        $region = 'ja';
        $sandbox = true;

        $objAmznPay = new SC_Helper_AmazonPay(
            $merchant_id, $access_key, $secret_key, $client_id, $region, $sandbox
        );
        $this->assertInstanceOf('SC_Helper_AmazonPay', $objAmznPay);
    }

    public function testGetClient()
    {
        $merchant_id = 'merchant_id';
        $access_key = 'access_key';
        $secret_key = 'secret_key';
        $client_id = 'client_id';
        $region = 'ja';
        $sandbox = true;

        $objAmznPay = new SC_Helper_AmazonPay(
            $merchant_id, $access_key, $secret_key, $client_id, $region, $sandbox
        );

        /** @var AmazonPay\ClientInterface $client */
        $client = $objAmznPay->getClient();

        $this->assertEquals($merchant_id, $client->__get('merchant_id'));
        $this->assertEquals($access_key, $client->__get('access_key'));
        $this->assertEquals($secret_key, $client->__get('secret_key'));
        $this->assertEquals($client_id, $client->__get('client_id'));
        $this->assertEquals($region, $client->__get('region'));
        $this->assertEquals($sandbox, $client->__get('sandbox'));
    }
}
