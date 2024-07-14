<?php
include 'function-kategori.php';
error_reporting(0);
session_start();
if (!isset($_SESSION['login'])) {
    header("Location:" .  $baseurl . "login.php");
}
if (isset($_POST['submit'])) {
  if (tambah($_POST) > 0) {
    echo "<script>
          alert('Data Berhasil Ditambahkan!');
          document.location.href = 'dashboard.php';
        </script>";
  } else {
    echo "
        <script>
          alert('Data Gagal Ditambahkan!');
          document.location.href = 'tambah-kategori.php';
        </script>
    ";
  }
}
$title = 'Tambah Kategori';
include("layout/header.php");
$sidemenu = 'dashboard';
?>
<section class="lg:flex gap-8 mx-auto lg:w-[90%] mt-20 lg:mt-0">
  <?php
  include("layout/sidebar.php");
  ?>
  <main class="py-4 w-[90%] mx-auto lg:w-[75%] flex flex-col gap-8">
    <section>
      <div class="bg-white p-5 rounded-lg shadow-lg">
        <h1 class="font-bold text-3xl">Tambah Kategori</h1>
        <form action="" method="post" enctype="multipart/form-data">
          <div class="mt-5">
            <label for="nama" class="block mb-2 text-lg font-medium text-gray-900">Nama</label>
            <input type="text" id="nama" name="nama" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#213555] focus:border-[#213555] block w-full p-2.5" required/>
          </div>
          <button type="submit" name="submit" class="mt-5 px-4 py-2 bg-[#213555] text-white rounded-lg hover:bg-[#4F709C] duration-300">
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