<?php
include 'app/koneksi.php';
$tipe = mysqli_query($koneksi, "select * from tipe");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Rendi Wedding</title>
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
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet" />
</head>

<body class="font-plusJakartaSans text-slate-900">
  <header class="bg-[#0000009d] text-white fixed w-full">
    <nav class="border-gray-200 max-w-[1200px] mx-auto w-[90%] lg:w-full">
      <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto py-4">
        <a href="#" class="flex items-center space-x-3 rtl:space-x-reverse">
          <span class="self-center text-2xl font-semibold whitespace-nowrap">Rendi Wedding</span>
        </a>
        <button data-collapse-toggle="navbar-default" type="button" 0 class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-white rounded-lg lg:hidden hover:bg-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-600" aria-controls="navbar-default" aria-expanded="false">
          <span class="sr-only">Open main menu</span>
          <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15" />
          </svg>
        </button>
        <div class="hidden w-full lg:block lg:w-auto" id="navbar-default">
          <ul class="font-medium flex flex-col p-4 lg:p-0 mt-4 border border-gray-100 rounded-lg lg:flex-row lg:space-x-8 rtl:space-x-reverse lg:mt-0 md:border-0 bg-white lg:bg-inherit">
            <li>
              <a href="#" class="block py-2 px-3 text-slate-800 lg:text-white rounded hover:bg-emerald-500 lg:hover:bg-transparent lg:border-0 lg:hover:text-emerald-600 lg:p-0">Home</a>
            </li>
            <li>
              <a href="#tentang" class="block py-2 px-3 text-slate-800 lg:text-white rounded hover:bg-emerald-500 lg:hover:bg-transparent lg:border-0 lg:hover:text-emerald-600 lg:p-0">Tentang</a>
            </li>
            <li>
              <a href="#katalog" class="block py-2 px-3 text-slate-800 lg:text-white rounded hover:bg-emerald-500 lg:hover:bg-transparent lg:border-0 lg:hover:text-emerald-600 lg:p-0">Katalog</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </header>
  <di>
    <section class="bg-center bg-no-repeat bg-[url('https://flowbite.s3.amazonaws.com/docs/jumbotron/conference.jpg')] bg-gray-700 bg-blend-multiply">
      <div class="px-4 mx-auto max-w-[1200px] w-[90%] lg:w-full text-center py-24 lg:py-56">
        <h1 class="mb-4 text-4xl font-extrabold tracking-tight leading-none text-white md:text-5xl lg:text-6xl">
          Katalog undangan digital Wedding Online
        </h1>
        <p class="mb-8 text-lg font-normal text-gray-300 lg:text-xl sm:px-16 lg:px-48">
          Bikin udangan gak pakek lama, Digital undangan ajah!!! Yukk...
          buruan langsung diorder ajah.
        </p>
        <div class="flex flex-col space-y-4 sm:flex-row sm:justify-center sm:space-y-0">
          <a href="#" class="inline-flex justify-center items-center py-3 px-5 text-base font-medium text-center text-white rounded-lg bg-emerald-700 hover:bg-emerald-800 focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-900">
            Order Sekarang
            <svg class="w-3.5 h-3.5 ms-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
            </svg>
          </a>
        </div>
      </div>
    </section>
    <section class="pb-12 pt-24" id="tentang">
      <div class="max-w-[1200px] w-[90%] mx-auto lg:w-full">
        <h2 class="text-center font-extrabold text-emerald-600 text-[30px] mb-6">
          Tentang Kami
        </h2>
        <div class="md:grid grid-cols-2 gap-5 justify-between items-center">
          <img class="w-full" src="https://ayoonaj.github.io/wedding-online/img/cover%20promosi%20fix%20fix.jpg" alt="tentang kami" width="100%" height="auto" />
          <div class="w-full">
            <p>
              Selamat datang di Wedding Online ahlinya undangan digital yang
              tak terlupakan! Desain eksklusif, teknologi modern, dan
              efisiensi tanpa batas. Cocok untuk pernikahan, ulang tahun, dan
              acara khusus lainnya. Hubungi kami sekarang untuk merayakan
              momen Anda dengan keindahan digital yang praktis dan personal!
            </p>
          </div>
        </div>
      </div>
    </section>
    <div id="katalog"></div>
    <?php while ($rowTipe = mysqli_fetch_assoc($tipe)) : ?>
      <?php $undangan = mysqli_query($koneksi, "SELECT * FROM undangan WHERE tipe = '$rowTipe[id]'");
      if (mysqli_num_rows($undangan) == 0) {
        continue;
      }
      ?>
      <section class="py-12">
        <div class="max-w-[1200px] w-[90%] mx-auto lg:w-full h-full">
          <h2 class="text-center font-extrabold text-[30px] mb-6">
            <span class="text-emerald-700">Katalog</span> Undangan <?php echo $rowTipe["nama"] ?>
          </h2>
          <p class="text-center mb-6">
            Berikut adalah beberapa contoh undangan/ katalog yang bisa diakses
            untuk melihat design dan beberapa fitur yang disediakan.
          </p>
          <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-5">
            <?php while ($row = mysqli_fetch_assoc($undangan)) : ?>
              <div class="bg-white border-2 border-gray rounded-lg">
                <img src="public/images/<?php echo $row["gambar"] ?>" alt="card-1" width="100%" height="auto" class="block object-cover w-full object-center max-h-[200px]" />
                <div class="flex flex-col p-4">
                  <h3 class="font-bold text-[20px]"><?php echo $row["nama"] ?></h3>
                  <span><?php $kategori = "select nama from kategori where id = " . $row["kategori"];
                        $kat = mysqli_query($koneksi, $kategori);
                        $k = mysqli_fetch_assoc($kat);
                        echo $k["nama"]; ?></span>
                  <div class="flex gap-1 justify-between">
                    <a href="<?php echo $row["link"] ?>" class="block p-3 w-full text-center font-semibold bg-emerald-600 text-white rounded-lg hover:bg-emerald-800 duration-500">Preview</a>
                    <a href="https://wa.me/621363489750?text=Halo%20Kak,%20saya%20ingin%20memesan%20undangan%20*<?php echo $row["nama"] ?>*" target="_blank" class="block p-3 w-full text-center font-semibold bg-white border border-emerald-600 text-emerald-600 rounded-lg hover:bg-white-800 duration-500">Pesan</a>
                  </div>
                </div>
              </div>
            <?php endwhile; ?>
          </div>
        </div>
      </section>
    <?php endwhile; ?>
    </main>
    <footer class="py-4 bg-emerald-600 text-white text-center mx-auto w-full">
      Copyright © 2024 - Rendi wedding. All Rights Reserved.
    </footer>
    <script src="node_modules/flowbite/dist/flowbite.min.js"></script>
</body>

</html>