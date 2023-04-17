<?php
$asal_kota = $_GET['asal_kota'];
$tujuan_kota = $_GET['tujuan_kota'];
$berat = $_GET['berat'];
$kurir = $_GET['kurir'];

$key = 'ab27bf7e731eeee118f1e15ed742b3f9';
$cost_url = 'https://api.rajaongkir.com/starter/cost';

$curl = curl_init();

curl_setopt_array(
    $curl,
    array(
        CURLOPT_URL => $cost_url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "origin={$asal_kota}&destination={$tujuan_kota}&weight={$berat}&courier={$kurir}",
        CURLOPT_HTTPHEADER => array(
            "content-type: application/x-www-form-urlencoded",
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
foreach ($data->rajaongkir->results as $row) {
    echo '<table class="table">
    <thead>
      <tr>
        <th scope="col">Nama Ekspedisi</th>
        <th scope="col">Layanan</th>
        <th scope="col">Estimasi hari</th>
        <th scope="col">Biaya</th>
      </tr>
    </thead>
    <tbody>';
    for ($i = 0; $i < count($row->costs); $i++) {
        echo ' <tr>
        <td>' . $row->name . '</td>
        <td>' . $row->costs[$i]->service . ' (' . $row->costs[$i]->description . ')</td>
        <td>' . $row->costs[$i]->cost[0]->etd . '</td>
        <td>' . $row->costs[$i]->cost[0]->value . '</td>
      </tr>';
    }
    echo '    </tbody>
    </table>';

}
?>