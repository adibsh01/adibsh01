<?php
session_start();
require 'dbconnection/koneksi.php';

// Cek apakah identitas sudah diisi
if (!isset($_SESSION['nama'])) {
    header("Location: diagnosa.php");
    exit;
}

// Ambil semua gejala
$query = $conn->query("SELECT * FROM gejala ORDER BY kode_gejala ASC");
$gejala = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Konsultasi Diagnosa</title>

<script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-slate-100">

<div class="max-w-6xl mx-auto py-10 px-5">

    <!-- Header -->

    <div class="bg-gradient-to-r from-slate-900 to-blue-700 text-white rounded-2xl p-8 shadow-lg">

        <h1 class="text-3xl font-bold">

            🌙 Konsultasi Diagnosa Insomnia

        </h1>

        <p class="mt-2 text-slate-200">

            Langkah <b>2 dari 2</b>

        </p>

        <div class="w-full bg-white/30 rounded-full h-2 mt-5">

            <div class="bg-white h-2 rounded-full w-full"></div>

        </div>

    </div>

    <!-- Identitas -->

    <div class="bg-white rounded-xl shadow-lg p-6 mt-8">

        <h2 class="text-xl font-bold mb-4">

            Data Pengguna

        </h2>

        <div class="grid md:grid-cols-3 gap-5">

            <div>

                <p class="text-gray-500 text-sm">Nama</p>

                <p class="font-semibold">

                    <?= htmlspecialchars($_SESSION['nama']) ?>

                </p>

            </div>

            <div>

                <p class="text-gray-500 text-sm">Umur</p>

                <p class="font-semibold">

                    <?= $_SESSION['umur'] ?> Tahun

                </p>

            </div>

            <div>

                <p class="text-gray-500 text-sm">Jenis Kelamin</p>

                <p class="font-semibold">

                    <?= $_SESSION['jenis_kelamin'] ?>

                </p>

            </div>

        </div>

    </div>

<form action="proses_cf.php" method="POST">

<div class="space-y-6 mt-8">

<?php foreach($gejala as $g){ ?>

<div class="bg-white rounded-xl shadow-md p-6">

    <div class="flex justify-between items-center mb-4">

        <h3 class="font-bold text-lg">

            <?= $g['kode_gejala']; ?>

        </h3>

        <span class="text-sm bg-blue-100 text-blue-700 px-3 py-1 rounded-full">

            Gejala

        </span>

    </div>

    <p class="text-gray-700 mb-5">

        <?= htmlspecialchars($g['nama_gejala']); ?>

    </p>

    <div class="grid md:grid-cols-6 gap-3">

        <?php

        $pilihan=[

            "0"=>"Tidak",

            "0.2"=>"Kurang Yakin",

            "0.4"=>"Sedikit Yakin",

            "0.6"=>"Cukup Yakin",

            "0.8"=>"Yakin",

            "1"=>"Sangat Yakin"

        ];

        foreach($pilihan as $nilai=>$label){

        ?>

        <label class="cursor-pointer">

            <input
                type="radio"
                name="cf_user[<?= $g['kode_gejala']; ?>]"
                value="<?= $nilai; ?>"
                required
                class="hidden peer">

            <div class="border rounded-lg p-3 text-center
                        peer-checked:bg-blue-700
                        peer-checked:text-white
                        hover:bg-blue-100">

                <?= $label; ?>

            </div>

        </label>

        <?php } ?>

    </div>

</div>

<?php } ?>

</div>

<div class="mt-10 flex justify-between">

<a href="diagnosa.php"
class="bg-gray-300 hover:bg-gray-400 px-8 py-3 rounded-xl font-semibold">

← Kembali

</a>

<button
type="submit"
class="bg-blue-700 hover:bg-blue-800 text-white px-10 py-3 rounded-xl font-semibold">

Hitung Diagnosa

</button>

</div>

</form>

</div>

</body>
</html>