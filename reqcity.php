<?php

$province_id = $_GET['province_id'];
$key = 'ab27bf7e731eeee118f1e15ed742b3f9';
$city_url = 'https://api.rajaongkir.com/starter/city?province=';

$curl = curl_init();

curl_setopt_array(
    $curl,
    array(
        CURLOPT_URL => $city_url . $province_id,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "key: {$key}"
        ),
    )
);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    return "cURL Error #:" . $err;
} else {
    $data = json_decode($response);

}
foreach ($data->rajaongkir->results as $kota) {
    echo '<option value="' . $kota->city_id . '">' . $kota->city_name . '</option>';
}
?>