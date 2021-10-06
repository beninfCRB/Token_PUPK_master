<?php
$konek = mysqli_connect("localhost", "root", "", "ujian_lab");
date_default_timezone_set('Asia/Jakarta');

$tgl = date('Y-m-d');

function tgl_indo($date)
{
    $bulan = array(
        1 =>   'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    );
    $pecahkan = explode('-', $date);

    return $pecahkan[0] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[2];
}

$data = mysqli_query($konek, "SELECT * FROM token WHERE status = 'aktif' AND tanggal = '$tgl'");
$string = '';
$token_old = 0;

while ($token = mysqli_fetch_array($data)) {
    if ($token['id_token'] != $token_old) {
        $token_old = $token['id_token'];
        if ($token['mulai'] <= date('H:i') && $token['akhir'] > date('H:i') && date('H:i') < $token['akhir']) {
            $string = '<h1 class="text-danger">' . $token['nama_token'] . '</h1>';

            $mulai = explode(':', $token['mulai']);
            $akhir = explode(':', $token['akhir']);
            $tanggal = explode('-', $token['tanggal']);
            $time = explode(':', date('H:i:s'));

            // mencari mktime untuk tanggal 1 Januari 2011 00:00:00 WIB
            $selisih1 =  mktime($akhir[0], $akhir[1], 0, NULL, NULL, NULL);

            // mencari mktime untuk current time
            $selisih2 = mktime($mulai[0], $mulai[1], 0,  NULL, NULL, NULL);

            $selisih3 = mktime($time[0], $time[1], $time[2],  NULL, NULL, NULL);

            $now = $selisih3 - $selisih2;

            // mencari selisih detik antara kedua waktu
            $delta = ($selisih1 - $selisih2) - $now;

            // proses mencari jumlah jam
            $sisa1 = $delta % 86400;
            $a  = floor($sisa1 / 3600);

            // proses mencari jumlah menit
            $sisa2 = $sisa1 % 3600;
            $b = floor($sisa2 / 60);

            $sisa3 = $sisa2 % 60;
            $c = floor($sisa3 / 1);
?>

            <div class="ml-0 mt-4">
                <h5>
                    Tanggal :
                    <strong>
                        <?= tgl_indo(date("d-m-Y")) ?>
                    </strong>
                </h5>
            </div>
            <h5>
                Waktu :
                <strong>
                    <?= date("H:i:s") ?>
                </strong>
            </h5>
            </div>
            <div class="text-center mt-4">
                <?php if ($a == 0 && $b == 0 && $c >= 0 && $c < 10) { ?>
                    <h2>Sisa Waktu : <strong class="text-danger">Habis</strong></h2>
                <?php } elseif ($a == 0 && $b >= 0 && $b <= 15 && $c >= 0 && $c <= 60) { ?>
                    <h2>Sisa Waktu : <strong class="text-danger"><?= $a; ?> Jam <?= $b; ?> Menit <?= $c; ?> Detik</strong></h2>
                <?php } else { ?>
                    <h2>Sisa Waktu : <strong><?= $a; ?> Jam <?= $b; ?> Menit <?= $c; ?> Detik</strong></h2>
                <?php } ?>
            </div>
<?php
        } elseif (date('H:i') >= $token['akhir']) {
            $id = $token['id_token'];
            $wkt = date('H:i');
            mysqli_query($konek, "UPDATE token SET status = 'nonaktif' WHERE id_token = $id ");
            mysqli_query($konek, "UPDATE soal SET status = 'nonaktif' WHERE tanggal = '$tgl' AND akhir = '$wkt' ");
        }
    }
}

$ip_adress = mysqli_query($konek, "SELECT * FROM ip ORDER BY id_ip DESC LIMIT 1")
?>


<div class="card text-center mt-4">
    <div class="card-header">
        <strong>TOKEN</strong>
    </div>
    <div class="card-body">
        <h1>
            <strong><?= $string; ?></strong>
        </h1>
    </div>
</div>
<?php
while ($ip = mysqli_fetch_array($ip_adress)) {
?>
    <div class="text-center mt-4">
        <h2>URL : <strong class="text-success"><?= $ip['nama_ip']; ?>/aslab/mahassiwa</strong></h2>
    </div>
<?php
}
?>