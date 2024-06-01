<!-- SIDENAV -->
<div id="layoutSidenav_nav">
  <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
    <div class="sb-sidenav-menu">
      <div class="nav">
        <p class="nav-link">
          Selamat datang, <?php echo $pekerja; ?>
        </p>
        <a class="nav-link" href="index.php?page=dashboard">
          <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
          Stok Barang
        </a>
        <a class="nav-link" href="index.php?page=masuk">
          <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
          Barang Masuk
        </a>
        <a class="nav-link" href="index.php?page=keluar">
          <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
          Barang Keluar
        </a>
        <a class="nav-link" href="index.php?page=jenis">
          <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
          Jenis Barang
        </a>
        <a class="nav-link" href="index.php?page=distributor">
          <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
          Distributor
        </a>
        <?php if ($role == 'Kepala') : ?>
          <a class="nav-link" href="index.php?page=pekerja">
            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
            Pekerja
          </a>
        <?php endif; ?>
        <a class="nav-link" href="index.php?page=laporan_transaksi">
          <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
          Laporan Transaksi
        </a>
        <a class="nav-link" href="function.php?logout=true">
          Logout
        </a>
      </div>
    </div>
  </nav>
</div>
<!-- END SIDENAV -->