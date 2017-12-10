<?php

    /* 
    * Get data from aftership using curl
    * 
    */ 
    function callAfterShipAPI($method, $awbNum, $courier) {
        $trackingUrl = "https://api.aftership.com/v4/trackings/";
        $curlParams = [
            CURLOPT_HTTPHEADER      => array(
                'Content-Type: application/json',
                'aftership-api-key: 9e4f1b10-6527-4dca-ab6f-8010221e6a34'
            ),
            CURLOPT_URL             => $trackingUrl . $courier . "/" . $awbNum,
            CURLOPT_RETURNTRANSFER  => 1,
            CURLOPT_SSL_VERIFYPEER  => FALSE
        ];

        if (strtoupper($method == 'POST')) {
            $postData = [
                'tracking' => [
                    'slug'              => $courier,
                    'tracking_number'   => $awbNum
                ]
            ];
            $curlParams[CURLOPT_URL] = $trackingUrl;
            $curlParams[CURLOPT_POSTFIELDS] = json_encode($postData);
        }

        $myCurl = curl_init();
        curl_setopt_array($myCurl, $curlParams);

        $data = [
            'response'  => curl_exec($myCurl),
            'error'     => curl_error($myCurl),
            'info'      => curl_getinfo($myCurl)
        ];

        curl_close($myCurl);
        
        return $data;
    }

    

?>