<?php

include 'app/koneksi.php';

error_reporting(0);

session_start();

if (isset($_SESSION['login'])) {
    header("Location: admin/dashboard.php");
}

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM user WHERE email='$email'";
    $result = mysqli_query($koneksi, $sql);
    $row = mysqli_fetch_assoc($result);
    $password1 = $row['password'];

    if (password_verify($password, $password1)) { //memverifikasi apakah enkripsi password login sesuai
        $jabatan = $row['jabatan'];
        $_SESSION['login'] = true;
        $_SESSION['nama'] = $row['nama'];
        $_SESSION['id_pegawai'] = $row['id_pegawai'];
        header("Location: admin/dashboard.php");
    } else {
        echo "<script>alert('Email atau password Anda salah. Silahkan coba lagi!')</script>";
    }
}

?>


<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'plusJakartaSans': ['Plus Jakarta Sans', 'sans-serif'],
                    },
                },
            },
            plugins: [
                require('flowbite/plugin')
            ],
        }
    </script>

    <title>Hello, world!</title>
</head>

<body class="bg-emerald-600 flex justify-center items-center h-screen">
    <form class="bg-white p-4 rounded max-w-[360px] block" action="" method="post">
        <h1 class="text-center mb-4 text-xl font-bold">Login</h1>

        <div class="form-floating mb-3">
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500" id="email" placeholder="name@example.com" name="email" required>
        </div>

        <div class="form-floating mb-3">
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input type="password" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500" id="password" placeholder="123" name="password" required>
        </div>

        <button type="submit" class="w-full bg-emerald-500 text-white py-2 px-4 rounded-md hover:bg-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2" name="submit">Login</button>
    </form>
</body>


</html>