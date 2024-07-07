<?php
// konfigurasi database
$host       =   "localhost";
$user       =   "root";
$password   =   "";
$database   =   "rendiwed";
// perintah php untuk akses ke database
$koneksi = mysqli_connect($host, $user, $password, $database);
// periksa koneksi
if (mysqli_connect_errno()) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
$baseurl = "http://localhost/rendi-wed/";
