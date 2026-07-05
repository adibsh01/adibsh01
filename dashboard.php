<?php
session_start();
require '../dbconnection/koneksi.php';

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit;
}

// Hitung jumlah gejala
$totalGejala = $conn->query("SELECT COUNT(*) FROM gejala")->fetchColumn();

// Hitung jumlah penyakit
$totalPenyakit = $conn->query("SELECT COUNT(*) FROM penyakit")->fetchColumn();

// Hitung jumlah basis pengetahuan
$totalBasis = $conn->query("SELECT COUNT(*) FROM basis_pengetahuan")->fetchColumn();

// Hitung jumlah konsultasi
$totalDiagnosa = $conn->query("SELECT COUNT(*) FROM konsultasi")->fetchColumn();

// Riwayat terbaru
$stmt = $conn->query("
SELECT *
FROM konsultasi
ORDER BY id_konsultasi DESC
LIMIT 5
");

$riwayat = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">

<title>Dashboard Admin</title>

<script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-slate-100">

<div class="flex">

<!-- Sidebar -->

<div class="w-64 bg-slate-900 min-h-screen text-white">

<div class="p-6">

<h1 class="text-2xl font-bold">

🌙 Admin

</h1>

<p class="text-slate-400">

Sistem Pakar

</p>

</div>

<nav class="mt-8">

<a href="dashboard.php"
class="block px-6 py-3 bg-blue-700">

Dashboard

</a>

<a href="../admin/gejala/index.php"
class="block px-6 py-3 hover:bg-slate-700">

Data Gejala

</a>

<a href="../admin/penyakit/index.php"
class="block px-6 py-3 hover:bg-slate-700">

Data Penyakit

</a>

<a href="../admin/basis_pengetahuan/index.php"
class="block px-6 py-3 hover:bg-slate-700">

Basis Pengetahuan

</a>

<a href="../admin/konsultasi/index.php"
class="block px-6 py-3 hover:bg-slate-700">

Riwayat Diagnosa

</a>

<a href="logout.php"
class="block px-6 py-3 hover:bg-red-700">

Logout

</a>

</nav>

</div>

<!-- Content -->

<div class="flex-1 p-10">

<h1 class="text-4xl font-bold">

Dashboard

</h1>

<p class="text-gray-600 mt-2">

Selamat Datang,

<b><?= $_SESSION['nama_admin']; ?></b>

</p>

<div class="grid grid-cols-4 gap-6 mt-10">

<div class="bg-white rounded-xl shadow p-6">

<h2 class="text-gray-500">

Jumlah Gejala

</h2>

<p class="text-5xl font-bold text-blue-700 mt-3">

<?= $totalGejala ?>

</p>

</div>

<div class="bg-white rounded-xl shadow p-6">

<h2 class="text-gray-500">

Jenis Insomnia

</h2>

<p class="text-5xl font-bold text-blue-700 mt-3">

<?= $totalPenyakit ?>

</p>

</div>

<div class="bg-white rounded-xl shadow p-6">

<h2 class="text-gray-500">

Basis Pengetahuan

</h2>

<p class="text-5xl font-bold text-blue-700 mt-3">

<?= $totalBasis ?>

</p>

</div>

<div class="bg-white rounded-xl shadow p-6">

<h2 class="text-gray-500">

Total Diagnosa

</h2>

<p class="text-5xl font-bold text-blue-700 mt-3">

<?= $totalDiagnosa ?>

</p>

</div>

</div>

<div class="bg-white rounded-xl shadow mt-10">

<div class="p-6 border-b">

<h2 class="text-2xl font-bold">

Riwayat Diagnosa Terbaru

</h2>

</div>

<table class="w-full">

<thead class="bg-slate-900 text-white">

<tr>

<th class="p-3">No</th>

<th>Nama</th>

<th>Hasil</th>

<th>CF (%)</th>

<th>Tanggal</th>

</tr>

</thead>

<tbody>

<?php

$no=1;

foreach($riwayat as $r){

?>

<tr class="border-b hover:bg-slate-50">

<td class="text-center p-3">

<?= $no++; ?>

</td>

<td>

<?= htmlspecialchars($r['nama']); ?>

</td>

<td>

<?= htmlspecialchars($r['hasil']); ?>

</td>

<td class="text-center">

<?= $r['nilai_cf']; ?>%

</td>

<td class="text-center">

<?= $r['tanggal']; ?>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

</div>

</body>
</html>