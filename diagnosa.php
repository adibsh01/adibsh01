<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $_SESSION['nama'] = trim($_POST['nama']);
    $_SESSION['umur'] = $_POST['umur'];
    $_SESSION['jenis_kelamin'] = $_POST['jenis_kelamin'];

    header("Location: konsultasi.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diagnosa Insomnia</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-100">

<div class="min-h-screen flex items-center justify-center p-6">

    <div class="bg-white shadow-2xl rounded-2xl w-full max-w-2xl overflow-hidden">

        <!-- Header -->
        <div class="bg-gradient-to-r from-slate-900 to-blue-700 text-white p-8">

            <h1 class="text-3xl font-bold">
                🌙 Diagnosa Insomnia
            </h1>

            <p class="mt-2 text-slate-200">
                Langkah <strong>1 dari 2</strong> - Isi identitas Anda sebelum memulai diagnosa.
            </p>

            <!-- Progress -->
            <div class="mt-5">
                <div class="w-full bg-slate-600 rounded-full h-2">
                    <div class="bg-white h-2 rounded-full w-1/2"></div>
                </div>
            </div>

        </div>

        <!-- Form -->
        <form method="POST" class="p-8 space-y-6">

            <div>

                <label class="block font-semibold text-slate-700 mb-2">
                    👤 Nama Lengkap
                </label>

                <input
                    type="text"
                    name="nama"
                    required
                    placeholder="Masukkan nama lengkap"
                    class="w-full border border-gray-300 rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-blue-500">

            </div>

            <div class="grid md:grid-cols-2 gap-5">

                <div>

                    <label class="block font-semibold text-slate-700 mb-2">
                        🎂 Umur
                    </label>

                    <input
                        type="number"
                        name="umur"
                        min="10"
                        max="100"
                        required
                        placeholder="Contoh : 22"
                        class="w-full border border-gray-300 rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-blue-500">

                </div>

                <div>

                    <label class="block font-semibold text-slate-700 mb-2">
                        🚻 Jenis Kelamin
                    </label>

                    <select
                        name="jenis_kelamin"
                        required
                        class="w-full border border-gray-300 rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-blue-500">

                        <option value="">-- Pilih Jenis Kelamin --</option>
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>

                    </select>

                </div>

            </div>

            <!-- Informasi -->
            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg">

                <p class="text-sm text-gray-700">

                    ℹ️ Data yang Anda masukkan hanya digunakan untuk proses diagnosa dan penyimpanan riwayat konsultasi.

                </p>

            </div>

            <!-- Tombol -->
            <div class="flex justify-between pt-2">

                <a href="index.php"
                   class="px-6 py-3 rounded-xl bg-gray-300 hover:bg-gray-400 font-semibold transition">

                    ← Kembali

                </a>

                <button
                    type="submit"
                    class="px-8 py-3 rounded-xl bg-blue-700 hover:bg-blue-800 text-white font-semibold transition">

                    Lanjut Diagnosa →

                </button>

            </div>

        </form>

    </div>

</div>

</body>
</html>