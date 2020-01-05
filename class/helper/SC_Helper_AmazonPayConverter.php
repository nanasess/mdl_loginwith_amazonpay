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
        $Order['name02'] = '';
        list($Order['zip01'], $Order['zip02']) = explode('-', $PhysicalDestination['PostalCode']);
        $Order['pref'] = self::convertToPrefId($PhysicalDestination['StateOrRegion']);
        $Order['addr01'] = $PhysicalDestination['City'];
        $Order['addr02'] = $PhysicalDestination['AddressLine1'];
        if (array_key_exists('Phone', $PhysicalDestination)
            && $PhysicalDestination['Phone']) {
            $PhysicalDestination['Phone'] = str_replace(['‐', '-', '‑', '⁃'], '', $PhysicalDestination['Phone']);
            list($Order['tel01'], $Order['tel02'], $Order['tel03']) = str_split($PhysicalDestination['Phone'], 4);
        }

        return $Order;
    }

    protected static function convertToPrefId($StateOrRegion)
    {
        $prefs = [
            'Hokkaido' => 1,
            'Aomori' => 2,
            'Iwate' => 3,
            'Miyagi' => 4,
            'Akita' => 5,
            'Yamagata' => 6,
            'Fukushima' => 7,
            'Ibaragi' => 8,
            'Tochigi' => 9,
            'Gunma' => 10,
            'Saitama' => 11,
            'Chiba' => 12,
            'Tokyo' => 13,
            'Kanagawa' => 14,
            'Nigata' => 15,
            'Toyama' => 16,
            'Ishikawa' => 17,
            'Fukui' => 18,
            'Yamanashi' => 19,
            'Nagano' => 20,
            'Gifu' => 21,
            'Shizuoka' => 22,
            'Aichi' => 23,
            'Mie' => 24,
            'Shiga' => 25,
            'Kyoto' => 26,
            'Osaka' => 27,
            'Hyogo' => 28,
            'Nara' => 29,
            'Wakayama' => 30,
            'Tottori' => 31,
            'Shimane' => 32,
            'Okayama' => 33,
            'Hiroshima' => 34,
            'Yamaguchi' => 35,
            'Tokushima' => 36,
            'Kagawa' => 37,
            'Ehime' => 38,
            'Kochi' => 39,
            'Fukuoka' => 40,
            'Saga' => 41,
            'Nagasaki' => 42,
            'Kumamoto' => 43,
            'Oita' => 44,
            'Miyagi' => 45,
            'Kagoshima' => 46,
            'Okinawa' => 47,
            '北海道' => 1,
            '青森県' => 2,
            '岩手県' => 3,
            '宮城県' => 4,
            '秋田県' => 5,
            '山形県' => 6,
            '福島県' => 7,
            '茨城県' => 8,
            '栃木県' => 9,
            '群馬県' => 10,
            '埼玉県' => 11,
            '千葉県' => 12,
            '東京都' => 13,
            '神奈川県' => 14,
            '新潟県' => 15,
            '富山県' => 16,
            '石川県' => 17,
            '福井県' => 18,
            '山梨県' => 19,
            '長野県' => 20,
            '岐阜県' => 21,
            '静岡県' => 22,
            '愛知県' => 23,
            '三重県' => 24,
            '滋賀県' => 25,
            '京都府' => 26,
            '大阪府' => 27,
            '兵庫県' => 28,
            '奈良県' => 29,
            '和歌山県' => 30,
            '鳥取県' => 31,
            '島根県' => 32,
            '岡山県' => 33,
            '広島県' => 34,
            '山口県' => 35,
            '徳島県' => 36,
            '香川県' => 37,
            '愛媛県' => 38,
            '高知県' => 39,
            '福岡県' => 40,
            '佐賀県' => 41,
            '長崎県' => 42,
            '熊本県' => 43,
            '大分県' => 44,
            '宮崎県' => 45,
            '鹿児島県' => 46,
            '沖縄県' => 47
        ];

        return $prefs[$StateOrRegion];
    }
}
