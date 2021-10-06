<?php
$konek = mysqli_connect("localhost", "root", "", "ujian_lab");
date_default_timezone_set('Asia/Jakarta');
session_start();

$tanggal = date('Y-m-d');
$time = date('H:i');
$data = mysqli_query($konek, "SELECT * FROM token WHERE status = 'aktif' AND tanggal = '$tanggal'");

while ($token = mysqli_fetch_array($data)) {
    if ($token['mulai'] <= $time && $token['akhir'] >= $time) {
        echo '<h1 class="text-danger">' . $token['nama_token'] . '</h1>';

        //set session dulu dengan nama $_SESSION["mulai"]
        if (isset($_SESSION["mulai"])) {
            //jika session sudah ada
            $telah_berlalu = time() - $_SESSION["mulai"];
        } else {
            //jika session belum ada
            $_SESSION["mulai"]  = time();
            $telah_berlalu      = 0;
        }

        $hitung = (int)$token['akhir'] - (int)$token['mulai'];
        $wkt = $hitung * 60;


        $temp_waktu = ($wkt * 60) - $telah_berlalu; //dijadikan detik dan dikurangi waktu yang berlalu
        $temp_menit = (int)($temp_waktu / 60);                //dijadikan menit lagi
        $temp_detik = $temp_waktu % 60;                       //sisa bagi untuk detik

        if ($temp_menit < 60) {
            /* Apabila $temp_menit yang kurang dari 60 meni */
            $jam    = 0;
            $menit  = $temp_menit;
            $detik  = $temp_detik;
        } else {
            /* Apabila $temp_menit lebih dari 60 menit */
            $jam    = (int)($temp_menit / 60);    //$temp_menit dijadikan jam dengan dibagi 60 dan dibulatkan menjadi integer 
            $menit  = $temp_menit % 60;           //$temp_menit diambil sisa bagi ($temp_menit%60) untuk menjadi menit
            $detik  = $temp_detik;
        }
    }
}
?>

<script type="text/javascript">
    $(document).ready(function() {
        /** Membuat Waktu Mulai Hitung Mundur Dengan 
         * var detik;
         * var menit;
         * var jam;
         */
        var detik = <?= $detik; ?>;
        var menit = <?= $menit; ?>;
        var jam = <?= $jam; ?>;

        /**
         * Membuat function hitung() sebagai Penghitungan Waktu
         */
        function hitung() {
            /** setTimout(hitung, 1000) digunakan untuk 
             * mengulang atau merefresh halaman selama 1000 (1 detik) 
             */
            setTimeout(hitung, 1000);

            /** Jika waktu kurang dari 10 menit maka Timer akan berubah menjadi warna merah */
            if (menit < 10 && jam == 0) {
                var peringatan = 'style="color:red"';
            };

            /** Menampilkan Waktu Timer pada Tag #Timer di HTML yang tersedia */
            $('#timer').html(
                '<h1 align="center"' + peringatan + '>Sisa waktu anda <br />' + jam + ' jam : ' + menit + ' menit : ' + detik + ' detik</h1><hr>'
            );

            /** Melakukan Hitung Mundur dengan Mengurangi variabel detik - 1 */
            detik--;

            /** Jika var detik < 0
             * var detik akan dikembalikan ke 59
             * Menit akan Berkurang 1
             */
            if (detik < 0) {
                detik = 59;
                menit--;

                /** Jika menit < 0
                 * Maka menit akan dikembali ke 59
                 * Jam akan Berkurang 1
                 */
                if (menit < 0) {
                    menit = 59;
                    jam--;

                    /** Jika var jam < 0
                     * clearInterval() Memberhentikan Interval dan submit secara otomatis
                     */

                    if (jam < 0) {
                        clearInterval(hitung);
                        /** Variable yang digunakan untuk submit secara otomatis di Form */
                    }
                }
            }
        }
        /** Menjalankan Function Hitung Waktu Mundur */
        hitung();
    });
</script>

<div id='timer'></div>