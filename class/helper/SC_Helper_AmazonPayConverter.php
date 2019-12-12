<?php

class SC_Helper_AmazonPayConverter
{
    /**
     * @param array $result Array of OrderReferenceDetailsResult
     * @param array $Order
     * @return array Array of Order
     */
    public static function orderReferenceDetailsResultToArrayOfOrder(array $result, array $Order = [])
    {
        $GetOrderReferenceDetailsResult = $result['GetOrderReferenceDetailsResult'];
        $OrderReferenceDetails = $GetOrderReferenceDetailsResult['OrderReferenceDetails'];
        $Destination = $OrderReferenceDetails['Destination'];
        $PhysicalDestination = $Destination['PhysicalDestination'];

        $Order['name01'] = $PhysicalDestination['Name'];
        list($Order['zip01'], $Order['zip02']) = explode('-', $PhysicalDestination['PostalCode']);
        $Order['pref'] = $PhysicalDestination['StateOrRegion'];
        $Order['addr01'] = $PhysicalDestination['City'];
        $Order['addr02'] = $PhysicalDestination['AddressLine1'];
        if (array_key_exists('Phone', $PhysicalDestination)
            && $PhysicalDestination['Phone']) {
            list($Order['tel01'], $Order['tel02'], $Order['tel03']) = str_split($PhysicalDestination['Phone'], 4);
        }

        return $Order;
    }
}
