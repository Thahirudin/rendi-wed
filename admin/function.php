<?php
include '../app/koneksi.php';

function tambah($data)
{
    global $koneksi;

    $nama = htmlspecialchars($data['nama']);
    $tipe = htmlspecialchars($data['tipe']);
    $kategori = htmlspecialchars($data['kategori']);
    $link = htmlspecialchars($data['link']);

    // Mengambil informasi file gambar
    $nama_file = $_FILES['gambar']['name'];
    $ukuran_file = $_FILES['gambar']['size'];
    $tmp_file = $_FILES['gambar']['tmp_name'];
    $tipe_file = $_FILES['gambar']['type'];

    // Generate nama unik berdasarkan waktu upload
    $nama_file_baru = time() . '_' . $nama_file;

    // Memindahkan file gambar ke folder yang diinginkan dengan nama baru
    $upload_dir = '../public/images/';
    $target_file = $upload_dir . $nama_file_baru;

    if (move_uploaded_file($tmp_file, $target_file)) {
        // Jika upload berhasil, lakukan query untuk menyimpan data ke database
        $undangan = "INSERT INTO undangan (nama, tipe, kategori, link, gambar) VALUES ('$nama', '$tipe', '$kategori', '$link', '$nama_file_baru')";
        mysqli_query($koneksi, $undangan);

        return mysqli_affected_rows($koneksi);
    } else {
        // Jika upload gagal
        return false;
    }
}

function edit($id, $data)
{
    global $koneksi;

    $nama = htmlspecialchars($data['nama']);
    $tipe = htmlspecialchars($data['tipe']);
    $kategori = htmlspecialchars($data['kategori']);
    $link = htmlspecialchars($data['link']);

    // Cek apakah ada file gambar baru diupload
    if ($_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
        // Mengambil informasi file gambar
        $nama_file = $_FILES['gambar']['name'];
        $ukuran_file = $_FILES['gambar']['size'];
        $tmp_file = $_FILES['gambar']['tmp_name'];
        $tipe_file = $_FILES['gambar']['type'];

        // Generate nama unik berdasarkan waktu upload
        $nama_file_baru = time() . '_' . $nama_file;

        // Memindahkan file gambar baru ke folder yang diinginkan dengan nama baru
        $upload_dir = '../public/images/';
        $target_file = $upload_dir . $nama_file_baru;

        // Hapus gambar lama jika ada
        $query_select_gambar = "SELECT gambar FROM undangan WHERE id = $id";
        $result = mysqli_query($koneksi, $query_select_gambar);
        if ($result) {
            $row = mysqli_fetch_assoc($result);
            $gambar_lama = $row['gambar'];
            if (!empty($gambar_lama)) {
                $file_path = $upload_dir . $gambar_lama;
                if (file_exists($file_path)) {
                    unlink($file_path); // Hapus file gambar lama dari folder
                }
            }
        }

        // Pindahkan file gambar baru ke folder yang diinginkan dengan nama baru
        if (move_uploaded_file($tmp_file, $target_file)) {
            // Update data dengan gambar baru
            $query_update = "UPDATE undangan SET nama = '$nama', tipe = '$tipe', kategori = '$kategori', link = '$link', gambar = '$nama_file_baru' WHERE id = $id";
            mysqli_query($koneksi, $query_update);

            return mysqli_affected_rows($koneksi);
        } else {
            // Jika upload gambar baru gagal
            return false;
        }
    } else {
        // Jika tidak ada gambar baru diupload, hanya update data tanpa mengubah gambar
        $query_update = "UPDATE undangan SET nama = '$nama', tipe = '$tipe', kategori = '$kategori', link = '$link' WHERE id = $id";
        mysqli_query($koneksi, $query_update);

        return mysqli_affected_rows($koneksi);
    }
}
