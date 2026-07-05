<?php
session_start();

if (!isset($_SESSION['hasil_diagnosa'])) {
    header("Location: index.php");
    exit;
}

$data = $_SESSION['hasil_diagnosa'];
?>

<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Hasil Diagnosa</title>

<script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-slate-100">

<div class="max-w-5xl mx-auto py-10 px-5">

<div class="bg-white rounded-2xl shadow-xl overflow-hidden">

<!-- HEADER -->

<div class="bg-gradient-to-r from-slate-900 to-blue-700 text-white p-8">

<h1 class="text-4xl font-bold">

🌙 Hasil Diagnosa Insomnia

</h1>

<p class="mt-2 text-slate-200">

Berikut hasil diagnosa berdasarkan metode Certainty Factor

</p>

</div>

<!-- IDENTITAS -->

<div class="p-8 border-b">

<h2 class="text-2xl font-bold mb-5">

Data Pengguna

</h2>

<div class="grid md:grid-cols-3 gap-5">

<div>

<p class="text-gray-500">Nama</p>

<p class="font-semibold text-lg">

<?= htmlspecialchars($data['nama']); ?>

</p>

</div>

<div>

<p class="text-gray-500">Umur</p>

<p class="font-semibold text-lg">

<?= $data['umur']; ?> Tahun

</p>

</div>

<div>

<p class="text-gray-500">Jenis Kelamin</p>

<p class="font-semibold text-lg">

<?= $data['jenis_kelamin']; ?>

</p>

</div>

</div>

</div>

<!-- HASIL -->

<div class="p-8">

<h2 class="text-2xl font-bold mb-6">

Hasil Diagnosa

</h2>

<div class="bg-blue-50 border-l-8 border-blue-700 rounded-xl p-6">

<h3 class="text-3xl font-bold text-blue-800">

<?= $data['nama_penyakit']; ?>

</h3>

<p class="mt-4 text-gray-700">

<?= htmlspecialchars($data['deskripsi']); ?>

</p>

</div>

</div>

<!-- NILAI CF -->

<div class="px-8 pb-8">

<div class="flex justify-between mb-2">

<span class="font-semibold">

Nilai Certainty Factor

</span>

<span class="font-bold text-blue-700">

<?= $data['persentase']; ?> %

</span>

</div>

<div class="w-full bg-gray-300 rounded-full h-6">

<div
class="bg-blue-700 h-6 rounded-full text-white text-sm text-center"
style="width: <?= $data['persentase']; ?>%;">

<?= $data['persentase']; ?>%

</div>

</div>

</div>

<!-- KATEGORI -->

<div class="px-8 pb-8">

<h3 class="font-bold mb-3">

Kategori Diagnosa

</h3>

<?php

$warna="bg-green-600";

if($data['kategori']=="Sedang"){

$warna="bg-yellow-500";

}

if($data['kategori']=="Tinggi"){

$warna="bg-red-600";

}

?>

<span class="<?= $warna; ?> text-white px-5 py-2 rounded-full">

<?= $data['kategori']; ?>

</span>

</div>

<!-- GEJALA -->

<div class="px-8 pb-8">

<h3 class="text-xl font-bold mb-4">

Gejala yang Dipilih

</h3>

<div class="flex flex-wrap gap-3">

<?php foreach($data['gejala'] as $g){ ?>

<span class="bg-slate-200 px-4 py-2 rounded-lg">

<?= $g ?>

</span>

<?php } ?>

</div>

</div>

<!-- PERHITUNGAN -->

<div class="px-8 pb-8">

<h3 class="text-2xl font-bold mb-5">

Proses Perhitungan CF

</h3>

<table class="w-full border">

<thead>

<tr class="bg-slate-800 text-white">

<th class="p-3">Gejala</th>

<th>CF User</th>

<th>CF Pakar</th>

<th>CF(H,E)</th>

</tr>

</thead>

<tbody>

<?php foreach($data['detail'] as $d){ ?>

<tr class="border">

<td class="p-3">

<?= $d['gejala']; ?>

</td>

<td class="text-center">

<?= $d['cf_user']; ?>

</td>

<td class="text-center">

<?= $d['cf_pakar']; ?>

</td>

<td class="text-center">

<?= round($d['hasil'],3); ?>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

<!-- LANGKAH COMBINE -->

<div class="px-8 pb-8">

<h3 class="text-2xl font-bold mb-4">

Perhitungan Combine CF

</h3>

<div class="bg-gray-100 rounded-xl p-6">

<?php foreach($data['langkah'] as $l){ ?>

<p class="mb-3">

<?= $l; ?>

</p>

<?php } ?>

</div>

</div>

<!-- BUTTON -->

<div class="bg-gray-100 p-8 flex justify-between">

<a href="diagnosa.php"
class="bg-gray-500 hover:bg-gray-700 text-white px-8 py-3 rounded-lg">

Diagnosa Lagi

</a>

<button onclick="window.print()"
class="bg-blue-700 hover:bg-blue-800 text-white px-8 py-3 rounded-lg">

Cetak Hasil

</button>

</div>

</div>

</div>

</body>
</html>