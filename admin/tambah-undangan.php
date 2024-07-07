<?php
include 'function.php';
error_reporting(0);
session_start();
if (!isset($_SESSION['login'])) {
    header("Location:" .  $baseurl . "login.php");
}
$tipe_query = mysqli_query($koneksi, "SELECT * FROM tipe");
$tipes = [];
while ($rowTipe = mysqli_fetch_assoc($tipe_query)) {
  $tipes[] = $rowTipe;
}
$kategori_query = mysqli_query($koneksi, "SELECT * FROM kategori");
$kategoris = [];
while ($rowKategori = mysqli_fetch_assoc($kategori_query)) {
  $kategoris[] = $rowKategori;
}
$title = 'Admin Rendi Wedding';
$sidemenu = 'dashboard';
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
          document.location.href = 'tambah-undangan.php';
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
        <h1 class="font-bold text-3xl">Tambah Undangan</h1>
        <form action="" method="post" enctype="multipart/form-data">
          <div class="mt-5">
            <label for="nama" class="block mb-2 text-lg font-medium text-gray-900">Nama</label>
            <input type="text" id="nama" name="nama" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5" required/>
          </div>
          <div class="mt-5">
            <label for="tipe" class="block mb-2 text-lg font-medium text-gray-900">Tipe</label>
            <select name="tipe" id="tipe" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5" required>
              <?php foreach ($tipes as $tipe) : ?>
                <option value="<?php echo $tipe['id']; ?>"><?php echo $tipe['nama']; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="mt-5">
            <label for="kategori" class="block mb-2 text-lg font-medium text-gray-900">Kategori</label>
            <select name="kategori" id="kategori" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5" required>
              <?php foreach ($kategoris as $kategori) : ?>
                <option value="<?php echo $kategori['id']; ?>"><?php echo $kategori['nama']; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="mt-5">
            <label for="gambar" class="block mb-2 text-lg font-medium text-gray-900">Gambar</label>
            <input type="file" id="gambar" name="gambar" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5" required/>
          </div>
          <div class="mt-5">
            <label for="link" class="block mb-2 text-lg font-medium text-gray-900">Link Preview</label>
            <input type="text" id="link" name="link" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5" required/>
          </div>
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