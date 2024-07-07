<?php
include '../app/koneksi.php';

function tambah($data)
{
    global $koneksi;
    $nama = htmlspecialchars($data['nama']);
    $query = "INSERT INTO kategori (nama) VALUES ('$nama')";
    mysqli_query($koneksi, $query);
    return mysqli_affected_rows($koneksi);
}

function edit($id, $data)
{
    global $koneksi;
    $nama = htmlspecialchars($data['nama']);
    $query = "UPDATE kategori SET nama = '$nama' WHERE id = $id";
    mysqli_query($koneksi, $query);
    return mysqli_affected_rows($koneksi);
}
function hapus($id, $data)
{
    global $koneksi;
    $nama = htmlspecialchars($data['nama']);
    $query = "UPDATE kategori SET nama = '$nama' WHERE id = $id";
    mysqli_query($koneksi, $query);
    return mysqli_affected_rows($koneksi);
}
