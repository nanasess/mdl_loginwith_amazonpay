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
}
