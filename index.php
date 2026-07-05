<?php

require './dbconnection/koneksi.php';

// Ambil data penyakit
$queryPenyakit = $conn->query("SELECT * FROM penyakit");
$penyakitList = $queryPenyakit->fetchAll(PDO::FETCH_ASSOC);

// Hitung total penyakit
$totalPenyakit = count($penyakitList);

// Hitung total gejala
$queryGejala = $conn->query("SELECT COUNT(*) AS total FROM gejala");
$totalGejala = $queryGejala->fetch(PDO::FETCH_ASSOC)['total'];

?>
<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Sistem Pakar Diagnosa Insomnia</title>

<script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-slate-100">

<!-- Navbar -->

<nav class="bg-slate-900 text-white shadow-lg">

<div class="max-w-7xl mx-auto flex justify-between items-center px-8 py-4">

<h1 class="text-2xl font-bold">
🌙 Sistem Pakar Insomnia
</h1>

<div class="space-x-6">

<a href="#" class="hover:text-blue-400">Home</a>

<a href="#tentang" class="hover:text-blue-400">Tentang</a>

<a href="#penyakit" class="hover:text-blue-400">Informasi</a>

<a href="diagnosa.php" class="hover:text-blue-400">Diagnosa</a>

<a href="admin/login.php"
class="bg-blue-600 px-4 py-2 rounded-lg hover:bg-blue-700">
    Admin
</a>

</div>

</div>

</nav>

<!-- Hero -->

<section class="bg-gradient-to-r from-slate-900 to-blue-800 text-white">

<div class="max-w-7xl mx-auto px-8 py-24 flex flex-col md:flex-row items-center">

<div class="md:w-1/2">

<h2 class="text-5xl font-bold leading-tight">

Diagnosa Insomnia

dengan

Metode Certainty Factor

</h2>

<p class="mt-6 text-lg">

Kenali kemungkinan gangguan tidur yang Anda alami
berdasarkan gejala yang dirasakan.

</p>

<a href="diagnosa.php"
class="inline-block mt-8 bg-white text-blue-700 px-8 py-3 rounded-lg font-semibold hover:bg-gray-200">

Mulai Diagnosa

</a>

</div>

<div class="md:w-1/2 flex justify-center mt-10 md:mt-0">

<img src="../assets/gambar/insomnia.png"
class="w-96">

</div>

</div>

</section>

<!-- Statistik -->

<section class="max-w-6xl mx-auto py-14">

<div class="grid md:grid-cols-2 gap-8">

<div class="bg-white rounded-xl shadow-lg p-8 text-center">

<h3 class="text-gray-600 text-lg">

Jumlah Gejala

</h3>

<p class="text-5xl font-bold text-blue-700 mt-3">

<?= $totalGejala ?>

</p>

</div>

<div class="bg-white rounded-xl shadow-lg p-8 text-center">

<h3 class="text-gray-600 text-lg">

Jenis Insomnia

</h3>

<p class="text-5xl font-bold text-blue-700 mt-3">

<?= $totalPenyakit ?>

</p>

</div>

</div>

</section>

<!-- Tentang -->

<section id="tentang" class="bg-white py-16">

<div class="max-w-6xl mx-auto px-8">

<h2 class="text-4xl font-bold text-center">

Apa itu Insomnia?

</h2>

<p class="text-gray-600 mt-6 text-center text-lg">

Insomnia merupakan gangguan tidur yang menyebabkan seseorang
kesulitan untuk tidur, sering terbangun di malam hari,
atau bangun terlalu pagi sehingga kualitas tidur menurun.

</p>

</div>

</section>

<!-- Informasi -->

<section id="penyakit" class="py-16">

<div class="max-w-6xl mx-auto px-8">

<h2 class="text-4xl font-bold text-center mb-12">

Informasi Jenis Insomnia

</h2>

<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">

<?php foreach($penyakitList as $row){ ?>

<div class="bg-white shadow-lg rounded-xl p-6">

<h3 class="text-xl font-bold text-blue-700">

<?= htmlspecialchars($row['nama_penyakit']); ?>

</h3>

<p class="mt-3 text-gray-600">

<?= htmlspecialchars($row['deskripsi']); ?>

</p>

</div>

<?php } ?>

</div>

</div>

</section>

<!-- Cara -->

<section class="bg-slate-900 text-white py-16">

<div class="max-w-6xl mx-auto">

<h2 class="text-center text-4xl font-bold mb-12">

Cara Menggunakan Sistem

</h2>

<div class="grid md:grid-cols-4 gap-6 text-center">

<div>

<div class="text-5xl mb-3">1️⃣</div>

Isi Identitas

</div>

<div>

<div class="text-5xl mb-3">2️⃣</div>

Pilih Gejala

</div>

<div>

<div class="text-5xl mb-3">3️⃣</div>

Pilih Tingkat Keyakinan

</div>

<div>

<div class="text-5xl mb-3">4️⃣</div>

Lihat Hasil Diagnosa

</div>

</div>

</div>

</section>

<!-- Footer -->

<footer class="bg-slate-800 text-center text-white py-6">

Sistem Pakar Diagnosa Insomnia © 2026

</footer>
</body>
</html>