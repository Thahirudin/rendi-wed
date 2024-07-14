<?php
include '../app/koneksi.php';
error_reporting(0);
session_start();
if (!isset($_SESSION['login'])) {
    header("Location:" .  $baseurl . "login.php");
}
function hapusundangan($id)
{
  global $koneksi;
  $query_select_gambar = "SELECT gambar FROM undangan WHERE id = $id";
  $result = mysqli_query($koneksi, $query_select_gambar);
  $upload_dir = '../public/images/';
  $row = mysqli_fetch_assoc($result);
  $gambar_lama = $row['gambar'];
  mysqli_query($koneksi, "DELETE FROM undangan WHERE id = $id");
  if (!empty($gambar_lama)) {
    $file_path = $upload_dir . $gambar_lama;
    if (file_exists($file_path)) {
      unlink($file_path); // Hapus file gambar lama dari folder
    }
  }
  return mysqli_affected_rows($koneksi);
}
function hapustipe($id)
{
  global $koneksi;
  $upload_dir = '../public/images/';

  // Query untuk memilih semua gambar yang terkait dengan tipe yang akan dihapus
  $query_select_gambar = "SELECT gambar FROM undangan WHERE tipe = $id";
  $result = mysqli_query($koneksi, $query_select_gambar);

  // Iterasi dan hapus setiap gambar
  while ($row = mysqli_fetch_assoc($result)) {
    $gambar_lama = $row['gambar'];
    if (!empty($gambar_lama)) {
      $file_path = $upload_dir . $gambar_lama;
      if (file_exists($file_path)) {
        unlink($file_path); // Hapus file gambar lama dari folder
      }
    }
  }

  // Setelah semua gambar dihapus, hapus data dari tabel 'undangan'
  mysqli_query($koneksi, "DELETE FROM undangan WHERE tipe = $id");

  // Hapus data dari tabel 'tipe'
  mysqli_query($koneksi, "DELETE FROM tipe WHERE id = $id");

  // Periksa jumlah baris yang terpengaruh oleh operasi DELETE terakhir
  $affected_rows = mysqli_affected_rows($koneksi);

  // Kembalikan jumlah baris yang terpengaruh
  return $affected_rows;
}

function hapuskategori($id)
{
  global $koneksi;
  $upload_dir = '../public/images/';

  // Query untuk memilih semua gambar yang terkait dengan tipe yang akan dihapus
  $query_select_gambar = "SELECT gambar FROM undangan WHERE kategori = $id";
  $result = mysqli_query($koneksi, $query_select_gambar);

  // Iterasi dan hapus setiap gambar
  while ($row = mysqli_fetch_assoc($result)) {
    $gambar_lama = $row['gambar'];
    if (!empty($gambar_lama)) {
      $file_path = $upload_dir . $gambar_lama;
      if (file_exists($file_path)) {
        unlink($file_path); // Hapus file gambar lama dari folder
      }
    }
  }
  mysqli_query($koneksi, "DELETE FROM undangan WHERE kategori = $id");
  mysqli_query($koneksi, "DELETE FROM kategori WHERE id = $id");
  $affected_rows = mysqli_affected_rows($koneksi);
  return $affected_rows;
}

$tipe = mysqli_query($koneksi, "select * from tipe");
$kategori_query = mysqli_query($koneksi, "SELECT * FROM kategori");
$kategoris = [];
while ($rowKategori = mysqli_fetch_assoc($kategori_query)) {
  $kategoris[] = $rowKategori;
}
$user_query = mysqli_query($koneksi, "SELECT * FROM user");

$users = [];
while ($rowUser = mysqli_fetch_assoc($user_query)) {
  $users[] = $rowUser;
}
$type_query = mysqli_query($koneksi, "SELECT * FROM tipe");
$types = [];
while ($rowType = mysqli_fetch_assoc($type_query)) {
  $types[] = $rowType;
}
$title = 'Admin Rendi Wedding';
$sidemenu = 'dashboard';
include("layout/header.php");
if (isset($_POST['submit'])) {
  if (hapusundangan($_POST['id']) > 0) {
    echo "<script>
          alert('Undangan Berhasil Dihapuskann!');
          document.location.href = 'dashboard.php';
        </script>";
  } else {
    echo "
        <script>
          alert('Undangan Gagal Dihapuskan!');
          document.location.href = 'dashboard.php';
        </script>
    ";
  }
}
if (isset($_POST['hapustipe'])) {
  if (hapustipe($_POST['id']) > 0) {
    echo "<script>
          alert('Tipe Berhasil Dihapuskann!');
          document.location.href = 'dashboard.php';
        </script>";
  } else {
    echo "
        <script>
          alert('Tipe Gagal Dihapuskan!');
          document.location.href = 'dashboard.php';
        </script>
    ";
  }
}
if (isset($_POST['hapuskategori'])) {
  if (hapuskategori($_POST['id']) > 0) {
    echo "<script>
          alert('Kategori Berhasil Dihapuskann!');
          document.location.href = 'dashboard.php';
        </script>";
  } else {
    echo "
        <script>
          alert('Kategori Gagal Dihapuskan!');
          document.location.href = 'dashboard.php';
        </script>
    ";
  }
}
?>
<section class="lg:flex gap-8 mx-auto lg:w-[90%] mt-20 lg:mt-0">
  <?php
  include("layout/sidebar.php");
  ?>
  <main class="py-4 w-[90%] mx-auto lg:w-[75%] flex flex-col gap-8">
    <section class="grid lg:grid-cols-3 gap-8">
      <?php while ($rowTipe = mysqli_fetch_assoc($tipe)) : ?>
        <?php
        $totalData = "SELECT COUNT(*) AS total FROM undangan WHERE tipe = " . $rowTipe["id"];
        $total = mysqli_query($koneksi, $totalData);
        ?>
        <div class="bg-white p-5 rounded-lg shadow-lg border">
          <h2>Undangan <?php echo $rowTipe["nama"] ?></h2>
          <p class="font-bold text-[30px] text-center"><?php echo mysqli_fetch_assoc($total)["total"] ?></p>
        </div>
      <?php endwhile; ?>
    </section>
    <section>
      <div class="bg-white p-4 rounded-lg shadow-lg">
        <h2 class="text-[22px] font-bold mb-5 text-[#213555]">
          Data Undangan
        </h2>
        <a href="<?php echo $baseurl ?>admin/tambah-undangan.php" class="mb-5 inline-block rounded-lg text-white px-4 py-2 bg-[#213555] hover:bg-[#4F709C] duration-300">Tambah Undangan</a>
        <div class="overflow-x-auto">
          <table id="example1" class="display" style="width: 100%">
            <thead>
              <tr>
                <th>Nama</th>
                <th>Kategori</th>
                <th>Tipe</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php $undangan = mysqli_query($koneksi, "SELECT * FROM undangan"); ?>
              <?php while ($row = mysqli_fetch_assoc($undangan)) : ?>
                <tr>
                  <td><?php echo $row["nama"] ?></td>
                  <td><?php $kategori = "SELECT nama FROM kategori WHERE id = " . $row["kategori"];
                      $kat = mysqli_query($koneksi, $kategori);
                      $k = mysqli_fetch_assoc($kat);
                      echo $k["nama"]; ?></td>
                  <td><?php $tipeid = "SELECT nama FROM tipe WHERE id = " . $row["tipe"];
                      $tipes = mysqli_query($koneksi, $tipeid);
                      $tipe = mysqli_fetch_assoc($tipes);
                      echo $tipe["nama"]; ?></td>
                  <td>
                    <div class="flex gap-2">
                      <a href="<?php echo $row['link'] ?>" class="flex justify-center items-center bg-[#213555] text-center w-full py-2 px-4 rounded-lg text-white hover:bg-[#4F709C] duration-300">
                        <svg class="w-5 fill-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                          <!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                          <path d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z" />
                        </svg>
                      </a>
                      <a href="<?php echo $baseurl . "admin/edit-undangan.php?id=" . $row['id'] ?>" class="flex justify-center items-center bg-blue-700 text-center w-full py-2 px-4 rounded-lg text-white hover:bg-blue-500 duration-300">
                        <svg class="w-5 fill-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                          <!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                          <path d="M410.3 231l11.3-11.3-33.9-33.9-62.1-62.1L291.7 89.8l-11.3 11.3-22.6 22.6L58.6 322.9c-10.4 10.4-18 23.3-22.2 37.4L1 480.7c-2.5 8.4-.2 17.5 6.1 23.7s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L387.7 253.7 410.3 231zM160 399.4l-9.1 22.7c-4 3.1-8.5 5.4-13.3 6.9L59.4 452l23-78.1c1.4-4.9 3.8-9.4 6.9-13.3l22.7-9.1v32c0 8.8 7.2 16 16 16h32zM362.7 18.7L348.3 33.2 325.7 55.8 314.3 67.1l33.9 33.9 62.1 62.1 33.9 33.9 11.3-11.3 22.6-22.6 14.5-14.5c25-25 25-65.5 0-90.5L453.3 18.7c-25-25-65.5-25-90.5 0zm-47.4 168l-144 144c-6.2 6.2-16.4 6.2-22.6 0s-6.2-16.4 0-22.6l144-144c6.2-6.2 16.4-6.2 22.6 0s6.2 16.4 0 22.6z" />
                        </svg>
                      </a>
                      <form action="" method="post" class="w-full">
                        <input type="hidden" name="action" value="hapusundangan">
                        <input type="hidden" name="id" value="<?php echo $row["id"] ?>">
                        <button type="submit" name="submit" onclick=" return confirm('yakin?');" class="flex justify-center items-center bg-red-700 text-center w-full py-2 px-4 rounded-lg text-white hover:bg-red-500 duration-300">
                          <svg class="w-5 fill-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                            <!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                            <path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z" />
                          </svg>
                        </button>
                      </form>
                    </div>
                  </td>
                </tr>
              <?php endwhile; ?>

            </tbody>
            <tfoot>
              <tr>
                <th>Nama</th>
                <th>Kategori</th>
                <th>Tipe</th>
                <th>Aksi</th>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </section>
    <section>
      <div class="bg-white p-4 rounded-lg shadow-lg">
        <h2 class="text-[22px] font-bold mb-5 text-[#213555]">
          Data Tipe
        </h2>
        <a href="<?php echo $baseurl ?>admin/tambah-tipe.php" class="mb-5 inline-block rounded-lg text-white px-4 py-2 bg-[#213555] hover:bg-[#4F709C] duration-300">Tambah Tipe</a>
        <div class="overflow-x-auto">
          <table id="example2" class="display" style="width: 100%">
            <thead>
              <tr>
                <th>Nama</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($types as $type) : ?>
                <tr>
                  <td><?php echo $type["nama"] ?></td>
                  <td>
                    <div class="flex gap-2">
                      <a href="<?php echo $baseurl . "admin/edit-tipe.php?id=" . $type['id'] ?>" class="flex justify-center items-center bg-blue-700 text-center w-full py-2 px-4 rounded-lg text-white hover:bg-blue-500 duration-300">
                        <svg class="w-5 fill-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                          <!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                          <path d="M410.3 231l11.3-11.3-33.9-33.9-62.1-62.1L291.7 89.8l-11.3 11.3-22.6 22.6L58.6 322.9c-10.4 10.4-18 23.3-22.2 37.4L1 480.7c-2.5 8.4-.2 17.5 6.1 23.7s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L387.7 253.7 410.3 231zM160 399.4l-9.1 22.7c-4 3.1-8.5 5.4-13.3 6.9L59.4 452l23-78.1c1.4-4.9 3.8-9.4 6.9-13.3l22.7-9.1v32c0 8.8 7.2 16 16 16h32zM362.7 18.7L348.3 33.2 325.7 55.8 314.3 67.1l33.9 33.9 62.1 62.1 33.9 33.9 11.3-11.3 22.6-22.6 14.5-14.5c25-25 25-65.5 0-90.5L453.3 18.7c-25-25-65.5-25-90.5 0zm-47.4 168l-144 144c-6.2 6.2-16.4 6.2-22.6 0s-6.2-16.4 0-22.6l144-144c6.2-6.2 16.4-6.2 22.6 0s6.2 16.4 0 22.6z" />
                        </svg>
                      </a>
                      <form action="" method="post" class="w-full">
                        <input type="hidden" name="action" value="hapustipe">
                        <input type="hidden" name="id" value="<?php echo $type['id'] ?>">
                        <button type="submit" name="hapustipe" onclick="return confirm('Apakah Anda yakin ingin menghapus?');" class="flex justify-center items-center bg-red-700 text-center w-full py-2 px-4 rounded-lg text-white hover:bg-red-500 duration-300">
                          <svg class="w-5 fill-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                            <path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z" />
                          </svg>
                        </button>
                      </form>
                    </div>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
            <tfoot>
              <tr>
                <th>Nama</th>
                <th>Aksi</th>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </section>
    <section>
      <div class="bg-white p-4 rounded-lg shadow-lg">
        <h2 class="text-[22px] font-bold mb-5 text-[#213555]">
          Data Kategori
        </h2>
        <a href="<?php echo $baseurl ?>admin/tambah-kategori.php" class="mb-5 inline-block rounded-lg text-white px-4 py-2 bg-[#213555] hover:bg-[#4F709C] duration-300">Tambah Kategori</a>
        <div class="overflow-x-auto">
          <table id="example3" class="display" style="width: 100%">
            <thead>
              <tr>
                <th>Nama</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($kategoris as $kategori) : ?>
                <tr>
                  <td><?php echo $kategori["nama"] ?></td>
                  <td>
                    <div class="flex gap-2">
                      <a href="<?php echo $baseurl . "admin/edit-kategori.php?id=" . $kategori['id'] ?>" class="flex justify-center items-center bg-blue-700 text-center w-full py-2 px-4 rounded-lg text-white hover:bg-blue-500 duration-300">
                        <svg class="w-5 fill-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                          <!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                          <path d="M410.3 231l11.3-11.3-33.9-33.9-62.1-62.1L291.7 89.8l-11.3 11.3-22.6 22.6L58.6 322.9c-10.4 10.4-18 23.3-22.2 37.4L1 480.7c-2.5 8.4-.2 17.5 6.1 23.7s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L387.7 253.7 410.3 231zM160 399.4l-9.1 22.7c-4 3.1-8.5 5.4-13.3 6.9L59.4 452l23-78.1c1.4-4.9 3.8-9.4 6.9-13.3l22.7-9.1v32c0 8.8 7.2 16 16 16h32zM362.7 18.7L348.3 33.2 325.7 55.8 314.3 67.1l33.9 33.9 62.1 62.1 33.9 33.9 11.3-11.3 22.6-22.6 14.5-14.5c25-25 25-65.5 0-90.5L453.3 18.7c-25-25-65.5-25-90.5 0zm-47.4 168l-144 144c-6.2 6.2-16.4 6.2-22.6 0s-6.2-16.4 0-22.6l144-144c6.2-6.2 16.4-6.2 22.6 0s6.2 16.4 0 22.6z" />
                        </svg>
                      </a>
                      <form action="" method="post" class="w-full">
                        <input type="hidden" name="action" value="hapuskategori">
                        <input type="hidden" name="id" value="<?php echo $kategori['id'] ?>">
                        <button type="submit" name="hapuskategori" onclick="return confirm('Apakah Anda yakin ingin menghapus?');" class="flex justify-center items-center bg-red-700 text-center w-full py-2 px-4 rounded-lg text-white hover:bg-red-500 duration-300">
                          <svg class="w-5 fill-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                            <path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z" />
                          </svg>
                        </button>
                      </form>
                    </div>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
            <tfoot>
              <tr>
                <th>Nama</th>
                <th>Aksi</th>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </section>
    <section>
      <div class="bg-white p-4 rounded-lg shadow-lg">
        <h2 class="text-[22px] font-bold mb-5 text-[#213555]">
          Data User
        </h2>
        <a href="<?php echo $baseurl ?>admin/tambah-user.php" class="mb-5 inline-block rounded-lg text-white px-4 py-2 bg-[#213555] hover:bg-[#4F709C] duration-300">Tambah User</a>
        <div class="overflow-x-auto">
          <table id="example4" class="display" style="width: 100%">
            <thead>
              <tr>
                <th>Nama</th>
                <th>Email</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($users as $user) : ?>
                <tr>
                  <td><?php echo $user["nama"] ?></td>
                  <td><?php echo $user["email"] ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
            <tfoot>
              <tr>
                <th>Nama</th>
                <th>Aksi</th>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </section>
  </main>
</section>
<script src="../node_modules/flowbite/dist/flowbite.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
<script>
  $(document).ready(function() {
    $("#example1").DataTable();
    $("#example2").DataTable();
    $("#example3").DataTable();
    $("#example4").DataTable();
  });
</script>
<?php
include("layout/footer.php");
?>