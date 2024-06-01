<!-- LAPORAN TRANSAKSI PAGE -->
<main>
  <div class="container-fluid">
    <h1 class="mt-4">Laporan Transaksi</h1>
    <div class="card mb-4">
      <div class="card-header">
        <h4 class="text-center">Laporan Transaksi</h4>
      </div>
      <div class="card-body">
        <div class="table-responsive data-tables">
          <!-- TABEL LAPORAN TRANSAKSI -->
          <table class="table table-bordered" id="mauexport" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>Tanggal Transaksi</th>
                <th>Nama Barang</th>
                <th>Jenis Barang</th>
                <th>Status Transaksi</th>
                <th>Jumlah Barang</th>
                <th>Nama Pekerja</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $listlaporan = mysqli_query($koneksi, "select * from laporan_transaksi");
              while ($data = mysqli_fetch_array($listlaporan)) {
                $tanggal = $data['Tanggal Transaksi'];
                $barang = $data['Nama Barang'];
                $jenis = $data['Jenis Barang'];
                $status = $data['Status Transaksi'];
                $jumlah = $data['Jumlah Barang'];
                $admin = $data['Nama Pekerja'];
              ?>
                <tr>
                  <td><?= $tanggal; ?></td>
                  <td><?= $barang; ?></td>
                  <td><?= $jenis; ?></td>
                  <td><?= $status; ?></td>
                  <td><?= $jumlah; ?></td>
                  <td><?= $admin; ?></td>
                </tr>
              <?php
              };
              ?>
            </tbody>
          </table>
          <!-- END TABEL -->
        </div>
      </div>
    </div>
  </div>
</main>
<!-- END LAPORAN TRANSAKSI PAGE -->