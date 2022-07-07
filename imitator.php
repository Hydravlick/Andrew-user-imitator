<?php

function randomFloat($min = 0, $max = 1)
{
    return $min + mt_rand() / mt_getrandmax() * ($max - $min);
}

// base values
date_default_timezone_set("Europe/Kiev");
$hostname = "frontend.test";
$url = "http://" . $hostname . "/location/add";
$longitude = round(randomFloat(26.5546, 26.6134), 4);
$latitude = round(randomFloat(48.6503, 48.7339), 4);
$array = array();

while (1) {
    $data = array(
        'user_id' => '1',
        'latitude' => $latitude,
        'longitude' => $longitude,
        'time' => date('Y-m-d H:i:s', strtotime('now')),
    );
    // save data into array until sent as request
    $array[] = $data;
    print_r($data);
    //check if connection is alive
    if (connection_status() == 0) {
        $options = array(
            'http' => array(
                'method' => 'POST',
                'content' => json_encode($array),
                'header' => "Content-Type: application/json\r\n" .
                    "Accept: application/json\r\n"
            )
        );

        $context = stream_context_create($options);
        //send data
        $result = file_get_contents($url, false, $context);
        //unset array
        $array = [];
    }

    // juggling around
    $longitude = $longitude + round(randomFloat(-0.001, 0.001), 4);
    $latitude = $latitude + round(randomFloat(-0.001, 0.001), 4);
    sleep(30);

}