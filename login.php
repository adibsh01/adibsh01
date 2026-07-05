<?php
session_start();
require '../dbconnection/koneksi.php';

$error = "";

if(isset($_POST['login'])){

    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM admin WHERE username=?");
    $stmt->execute([$username]);

    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if($admin){

        // Jika password masih plaintext
        if($password == $admin['password']){

            $_SESSION['admin'] = $admin['id_admin'];
            $_SESSION['nama_admin'] = $admin['nama'];

            header("Location: dashboard.php");
            exit;

        }else{

            $error = "Password salah.";

        }

    }else{

        $error = "Username tidak ditemukan.";

    }

}
?>

<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">

<title>Login Admin</title>

<script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-slate-100">

<div class="min-h-screen flex items-center justify-center">

<div class="bg-white shadow-xl rounded-2xl w-full max-w-md">

<div class="bg-slate-900 text-white p-8 rounded-t-2xl">

<h1 class="text-3xl font-bold">

Login Admin

</h1>

<p class="text-slate-300 mt-2">

Sistem Pakar Diagnosa Insomnia

</p>

</div>

<form method="POST" class="p-8 space-y-5">

<?php if($error!=""){ ?>

<div class="bg-red-100 text-red-700 p-3 rounded">

<?= $error ?>

</div>

<?php } ?>

<div>

<label class="font-semibold">

Username

</label>

<input
type="text"
name="username"
required
class="w-full border rounded-lg p-3 mt-2">

</div>

<div>

<label class="font-semibold">

Password

</label>

<input
type="password"
name="password"
required
class="w-full border rounded-lg p-3 mt-2">

</div>

<button
name="login"
class="w-full bg-blue-700 hover:bg-blue-800 text-white p-3 rounded-lg">

Login

</button>

</form>

</div>

</div>

</body>
</html>