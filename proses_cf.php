<?php
session_start();
require 'dbconnection/koneksi.php';

// Pastikan data dikirim dari konsultasi
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: konsultasi.php");
    exit;
}

// Ambil identitas user dari session
$nama = $_SESSION['nama'];
$umur = $_SESSION['umur'];
$jenis_kelamin = $_SESSION['jenis_kelamin'];

// Ambil jawaban user
$cf_user = $_POST['cf_user'];

// Ambil seluruh basis pengetahuan beserta data penyakit
$sql = "
SELECT
    bp.kode_penyakit,
    bp.kode_gejala,
    bp.cf_pakar,
    p.nama_penyakit,
    p.deskripsi
FROM basis_pengetahuan bp
JOIN penyakit p
ON bp.kode_penyakit = p.kode_penyakit
ORDER BY bp.kode_penyakit
";

$stmt = $conn->query($sql);
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Kelompokkan berdasarkan penyakit
$penyakit = [];

foreach ($data as $row) {

    $kode = $row['kode_penyakit'];

    if (!isset($penyakit[$kode])) {

        $penyakit[$kode] = [

            'nama' => $row['nama_penyakit'],
            'deskripsi' => $row['deskripsi'],
            'cf' => [],
            'proses' => []

        ];

    }

    $kode_gejala = $row['kode_gejala'];

    // Ambil nilai CF User
    $nilai_user = isset($cf_user[$kode_gejala]) ? (float)$cf_user[$kode_gejala] : 0;

    // Hitung CF(H,E)
    $cf_he = $nilai_user * (float)$row['cf_pakar'];

    // Simpan nilai CF
    $penyakit[$kode]['cf'][] = $cf_he;

    // Simpan proses perhitungan
    $penyakit[$kode]['proses'][] = [

        'gejala' => $kode_gejala,
        'cf_user' => $nilai_user,
        'cf_pakar' => $row['cf_pakar'],
        'hasil' => $cf_he

    ];

}
// ======================================
// BAGIAN 2
// Combine Certainty Factor
// ======================================

$hasil_akhir = [];

foreach ($penyakit as $kode => $item) {

    $cf_list = $item['cf'];

    // Jika tidak ada nilai CF
    if (count($cf_list) == 0) {
        continue;
    }

    // Nilai pertama
    $combine = array_shift($cf_list);

    $langkah = [];

    // Simpan nilai awal
    $langkah[] = "CF Awal = " . round($combine, 4);

    // Combine satu per satu
    foreach ($cf_list as $nilai) {

        $cf_lama = $combine;

        $combine = $combine + ($nilai * (1 - $combine));

        $langkah[] =
            round($cf_lama,4)
            ." + ("
            .round($nilai,4)
            ." × (1 - "
            .round($cf_lama,4)
            .")) = "
            .round($combine,4);

    }

    $hasil_akhir[$kode] = [

        'nama' => $item['nama'],
        'deskripsi' => $item['deskripsi'],
        'nilai_cf' => $combine,
        'persentase' => round($combine * 100,2),
        'detail' => $item['proses'],
        'langkah' => $langkah

    ];

}


// ======================================
// Cari nilai terbesar
// ======================================

$hasil = null;

foreach ($hasil_akhir as $kode => $item){

    if($hasil == null){

        $hasil = $item;
        $hasil['kode'] = $kode;

    }else{

        if($item['nilai_cf'] > $hasil['nilai_cf']){

            $hasil = $item;
            $hasil['kode'] = $kode;

        }

    }

}


// ======================================
// Jika tidak ada hasil
// ======================================

if($hasil == null){

    die("Tidak ada hasil diagnosa.");

}


// ======================================
// Menentukan kategori hasil
// ======================================

if($hasil['persentase'] >= 80){

    $kategori = "Tinggi";

}elseif($hasil['persentase'] >= 50){

    $kategori = "Sedang";

}else{

    $kategori = "Rendah";

}


// Simpan ke session
$_SESSION['hasil_cf'] = $hasil;
// ======================================
// BAGIAN 3
// Simpan Hasil Diagnosa ke Database
// ======================================

// Ambil gejala yang dipilih user
$gejalaDipilih = [];

foreach ($cf_user as $kode => $nilai) {

    if ((float)$nilai > 0) {
        $gejalaDipilih[] = $kode;
    }

}

$gejalaString = implode(", ", $gejalaDipilih);

// Simpan ke database
$stmt = $conn->prepare("
INSERT INTO konsultasi
(
    nama,
    umur,
    jenis_kelamin,
    tanggal,
    hasil,
    nilai_cf,
    gejala_terpilih
)
VALUES
(
    ?,
    ?,
    ?,
    NOW(),
    ?,
    ?,
    ?
)
");

$stmt->execute([

    $nama,
    $umur,
    $jenis_kelamin,
    $hasil['nama'],
    $hasil['persentase'],
    $gejalaString

]);

// Simpan hasil ke SESSION
$_SESSION['hasil_diagnosa'] = [

    'nama' => $nama,
    'umur' => $umur,
    'jenis_kelamin' => $jenis_kelamin,

    'kode_penyakit' => $hasil['kode'],
    'nama_penyakit' => $hasil['nama'],
    'deskripsi' => $hasil['deskripsi'],

    'nilai_cf' => $hasil['nilai_cf'],
    'persentase' => $hasil['persentase'],

    'kategori' => $kategori,

    'gejala' => $gejalaDipilih,

    'detail' => $hasil['detail'],

    'langkah' => $hasil['langkah']

];

// Redirect
header("Location: hasil.php");
exit;