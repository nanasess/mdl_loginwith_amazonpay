<?php

use PHPUnit\Framework\TestCase;

class SC_Helper_AmazonPayConverterTest extends TestCase
{
    public function testConvertToOrder()
    {
        $GetOrderReferenceDetailsResult = array (
            'GetOrderReferenceDetailsResult' =>
            array (
                'OrderReferenceDetails' =>
                array (
                    'OrderReferenceStatus' =>
                    array (
                        'State' => 'Draft',
                    ),
                    'Destination' =>
                    array (
                        'DestinationType' => 'Physical',
                        'PhysicalDestination' =>
                        array (
                            'StateOrRegion' => 'Tokyo',
                            'City' => 'Ota-ku',
                            'Phone' => '09056412829',
                            'CountryCode' => 'JP',
                            'PostalCode' => '144-8588',
                            'Name' => 'JP APA test test1',
                            'AddressLine1' => '1-17-25 Shinkamata',
                        ),
                    ),
                    'ExpirationTimestamp' => '2020-06-05T04:28:34.422Z',
                    'IdList' =>
                    array (
                    ),
                    'SellerOrderAttributes' =>
                    array (
                    ),
                    'Constraints' =>
                    array (
                        'Constraint' =>
                        array (
                            'ConstraintID' => 'AmountNotSet',
                            'Description' => 'The seller has not set the amount for the Order Reference.',
                        ),
                    ),
                    'Buyer' =>
                    array (
                        'Name' => ' 大河内健太郎',
                        'Email' => 'ohkouchi@loop-az.co.jp',
                    ),
                    'ReleaseEnvironment' => 'Sandbox',
                    'AmazonOrderReferenceId' => 'S03-4494200-5175347',
                    'CreationTimestamp' => '2019-12-08T04:28:34.422Z',
                    'RequestPaymentAuthorization' => 'false',
                ),
            ),
            'ResponseMetadata' =>
            array (
                'RequestId' => 'a3710a8e-1eaa-48fd-b02a-0e830d6f3e37',
            ),
            'ResponseStatus' => '200',
        );

        $Order = SC_Helper_AmazonPayConverter::orderReferenceDetailsResultToArrayOfOrder(
            $GetOrderReferenceDetailsResult
        );

        $this->assertEquals('JP APA test test1', $Order['name01']);
        $this->assertEquals('144', $Order['zip01']);
        $this->assertEquals('8588', $Order['zip02']);
        $this->assertEquals('0905', $Order['tel01']);
        $this->assertEquals('6412', $Order['tel02']);
        $this->assertEquals('829', $Order['tel03']);
        $this->assertEquals('Ota-ku', $Order['addr01']);
        $this->assertEquals('1-17-25 Shinkamata', $Order['addr02']);
    }
}
