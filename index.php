<?php
$province_url = 'https://api.rajaongkir.com/starter/province';
$key = 'ab27bf7e731eeee118f1e15ed742b3f9';
$curl = curl_init();

curl_setopt_array(
    $curl,
    array(
        CURLOPT_URL => $province_url,
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
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
    <title>Raja ongkir</title>
</head>

<body>
    <div>
        <div class=" p-5 bg-primary text-white text-center">
            <h1 style="font-family:roboto; font-weight:700;">Cek ongkos kirim</h1>
            <p>Menghitung biaya ongkos kirim</p>
        </div>
        <div class="container">
            <div class="row mt-4">
                <div class="col-sm-3">
                    <h3>Kota Asal</h3>
                    <p>
                        Pilih Provinsi
                        <select name="provinsi_asal" class="form-select" onchange="kotaAsal(this.value)">
                            <option>-- Pilih Provinsi --</option>
                            <?php foreach ($data->rajaongkir->results as $row): ?>
                                <option value="<?= $row->province_id ?>"><?= $row->province ?></option>
                            <?php endforeach; ?>
                        </select>
                    </p>
                    <p>
                        Pilih Kota
                        <select name="kota_asal" class="form-select" id="kota_asal">
                            <option>-- Pilih Kota --</option>
                        </select>
                    </p>
                    <h3>Ongkos kirim</h3>
                    <p>
                        Berat paket(GRAM):
                        <input id="berat" type="text" nama="berat" class="form-control">
                    </p>
                </div>
                <div class="col-sm-3">
                    <h3>Kota Tujuan</h3>
                    <p>
                        Pilih Provinsi
                        <select name="provinsi_tujuan" class="form-select" onchange="kotaTujuan(this.value)">
                            <option>-- Pilih Provinsi --</option>
                            <?php foreach ($data->rajaongkir->results as $row): ?>
                                <option value="<?= $row->province_id ?>"><?= $row->province ?></option>
                            <?php endforeach; ?>
                        </select>
                    </p>
                    <p>
                        Pilih Kota
                        <select name="kota_tujuan" class="form-select" id="kota_tujuan">
                            <option>-- Pilih Kota --</option>
                        </select>
                    </p>
                    <h3>Pilih Kurir</h3>
                    <p>
                        Pilih Kurir:
                        <select name="kurir" id="kurir" class="form-select">
                            <option value="jne">jne</option>
                            <option value="tiki">tiki</option>
                            <option value="pos">pos</option>
                        </select>
                    </p>
                    <p>
                        <input class="btn btn-primary" type="submit" value="Cek Ongkir" name="cari"
                            onclick="cekOngkir()">
                    </p>
                </div>
                <div class="col-sm-6">
                    <h3>Daftar ongkos kirim</h3>
                    <div id="hasil"></div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function kotaAsal(province_id) {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("kota_asal").innerHTML = this.responseText;
                }
            };
            xmlhttp.open("GET", "http://localhost/rajaongkir/reqcity.php?province_id=" + province_id, true);
            xmlhttp.send();
        }

        function kotaTujuan(province_id) {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("kota_tujuan").innerHTML = this.responseText;
                }
            };
            xmlhttp.open("GET", "http://localhost/rajaongkir/reqcity.php?province_id=" + province_id, true);
            xmlhttp.send();
        }

        function cekOngkir() {
            var kota_asal = document.getElementById("kota_asal").value;
            var kota_tujuan = document.getElementById("kota_tujuan").value;
            var berat = document.getElementById("berat").value;
            var kurir = document.getElementById("kurir").value;

            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("hasil").innerHTML = this.responseText;
                }
            };
            xmlhttp.open("GET", "http://localhost/rajaongkir/reqcost.php?asal_kota=" + kota_asal + "&tujuan_kota=" + kota_tujuan + "&berat=" + berat + "&kurir=" + kurir + "", true);
            xmlhttp.send();
        }

    </script>
</body>

</html>