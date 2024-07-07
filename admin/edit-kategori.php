<?php
include 'function-kategori.php';
error_reporting(0);
session_start();
if (!isset($_SESSION['login'])) {
    header("Location:" .  $baseurl . "login.php");
}
$id = $_GET["id"];
$kategori_query = mysqli_query($koneksi, "SELECT * FROM kategori where id = '$id'");
$kategoris = [];
while ($rowkategori = mysqli_fetch_assoc($kategori_query)) {
  $kategoris[] = $rowkategori;
}
$title = 'Admin Rendi Wedding';
$sidemenu = 'dashboard';
if (isset($_POST['submit'])) {
  $result = edit($id, $_POST);
  if ($result > 0) {
    echo "<script>
          alert('Data Berhasil Diedit!');
          document.location.href = 'dashboard.php';
        </script>";
  } else {
    echo "
        <script>
          alert('Data Gagal Ditambahkan!');
          document.location.href = 'edit-kategori.php?id=$id';
        </script>
    ";
  }
}
include("layout/header.php");
?>
<section class="lg:flex gap-8 mx-auto lg:w-[90%] mt-20 lg:mt-0">
  <?php
  include("layout/sidebar.php");
  ?>
  <main class="py-4 w-[90%] mx-auto lg:w-[75%] flex flex-col gap-8">
    <section>
      <div class="bg-white p-5 rounded-lg shadow-lg">
        <h1 class="font-bold text-3xl">Edit Kategori</h1>
        <form action="" method="post" enctype="multipart/form-data">
          <?php foreach ($kategoris as $kategori) : ?>
            <div class="mt-5">
              <label for="nama" class="block mb-2 text-lg font-medium text-gray-900">Nama</label>
              <input type="text" id="nama" name="nama" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5" value="<?php echo $kategori['nama']; ?>" required/>
            </div>
          <?php endforeach; ?>
          <button type="submit" name="submit" class="mt-5 px-4 py-2 bg-emerald-500 text-white rounded-lg hover:bg-emerald-600 duration-300">
            Submit
          </button>
        </form>
      </div>
    </section>
  </main>
</section>

<?php
include("layout/footer.php");
?>