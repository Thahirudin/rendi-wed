<?php
include '../app/koneksi.php';

function tambah($data)
{
    global $koneksi;
    $nama = htmlspecialchars($data['nama']);
    $email = htmlspecialchars($data['email']);
    $password = htmlspecialchars($data['password']);
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $query = "INSERT INTO user (nama, email, password) VALUES ('$nama', '$email', '$password_hash')";
    mysqli_query($koneksi, $query);
    return mysqli_affected_rows($koneksi);
}
function edit($id, $data)
{
    global $koneksi;
    $nama = htmlspecialchars($data['nama']);
    $email = htmlspecialchars($data['email']);
    $password = htmlspecialchars($data['password']);
    if ($password == '') {
        $query = "UPDATE user SET email = '$email', nama = '$nama' WHERE id = $id";
    } else {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $query = "UPDATE user SET email = '$email', password = '$password_hash', nama = '$nama' WHERE id = $id";
    }
    mysqli_query($koneksi, $query);
    return mysqli_affected_rows($koneksi);
}
