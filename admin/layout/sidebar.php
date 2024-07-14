<aside class="hidden absolute z-[100] lg:static lg:flex flex-col lg:w-[25%]" id="navbar-default">
  <section class="fixed h-screen lg:py-4 w-[70%] md:w-[35%] lg:w-[20%] ">
    <div class="block p-4 bg-white h-screen w-full lg:h-[95vh] rounded-xl border-2 shadow-lg">
      <h1 class="hidden lg:block mb-5 font-bold text-[24px] text-[#213555]">
        Rendi Wedding
      </h1>
      <ul class="flex flex-col font-semibold">
        <li>
          <a href="<?php echo $baseurl ?>admin/dashboard.php" class="<?php if ($sidemenu == 'dashboard') {
                                                                        echo 'bg-[#213555] text-white ';
                                                                      } ?>hover:bg-[#213555] block hover:text-white p-4 rounded-lg duration-300 ease-out">Dashboard</a>
        </li>
        <li>
          <a href="<?php echo $baseurl ?>admin/profil.php" class="<?php if ($sidemenu == 'profil') {
                                echo 'bg-[#213555] text-white ';
                              } ?>hover:bg-[#213555] block hover:text-white p-4 rounded-lg duration-300 ease-out">Profil</a>
        </li>
        <li>
          <form action="<?php echo $baseurl ?>logout.php" class="">
            <button type="submit" class="hover:bg-[#213555] block w-full text-left hover:text-white p-4 rounded-lg duration-300 ease-out">Logout
            </button>
          </form>

        </li>
      </ul>
    </div>
  </section>
</aside>