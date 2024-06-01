<!-- TRANSAKSI MASUK PAGE -->
<main>
  <div class="container-fluid">
    <h1 class="mt-4">Barang Masuk</h1>
    <div class="card mb-4">
      <div class="card-header">
        <button type="button" class="btn bg-primary text-white" data-toggle="modal" data-target="#myModal"> Tambah Barang </button>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <!-- TABEL TRANSAKSI MASUK -->
          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>Tanggal</th>
                <th>Nama Barang</th>
                <th>Jenis Barang</th>
                <th>Jumlah</th>
                <th>Admin</th>
                <th>Opsi</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $result = mysqli_query($koneksi, "SELECT USER() AS username");
              if ($result === false) {
                throw new Exception("Query failed: " . mysqli_error($koneksi));
              }
              $row = mysqli_fetch_assoc($result);
              $_SESSION['username'] = $row['username'];
              $listbarangmasuk = mysqli_query($koneksi, "SELECT * FROM transaksi t JOIN barang b ON b.id_barang = t.id_barang JOIN pekerja p ON p.id_pekerja = t.id_pekerja JOIN jenis j ON b.id_jenis = j.id_jenis
                                        WHERE t.keterangan = 'in' OR t.keterangan = 'new'");
              while ($data = mysqli_fetch_array($listbarangmasuk)) {
                $id = $data['id_transaksi'];
                $idb = $data['id_barang'];
                $idp = $data['id_pekerja'];
                $jumlah = $data['jumlah_barang'];
                $tanggal = $data['tanggal'];
                $keterangan = $data['keterangan'];
                $barang = $data['barang'];
                $admin = $data['nama_pekerja'];
                $jenis = $data['jenis_barang'];
              ?>
                <tr>
                  <td><?= $tanggal; ?></td>
                  <td><?= $barang; ?></td>
                  <td><?= $jenis; ?></td>
                  <td><?= $jumlah; ?></td>
                  <td><?= $admin; ?></td>
                  <?php include './components/action_button.php'; ?>
                </tr>
                <!-- Modal edit transaksi masuk -->
                <div class="modal fade" id="edit<?= $id; ?>">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title">Edit Barang Masuk</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                      </div>
                      <form method="post">
                        <div class="modal-body">
                          <div class="form-control"><?= $barang; ?></div>
                          <br>
                          <input type="number" name="jumlah" value="<?= $jumlah; ?>" class="form-control" required>
                          <br>
                          <input type="hidden" name="idt" value="<?= $id; ?>">
                          <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" name="updateTransaksi">Edit</button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>

                <!-- Modal delete table transaksi masuk -->
                <div class="modal fade" id="delete<?= $id; ?>">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title">Hapus Transaksi</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                      </div>
                      <form method="post">
                        <div class="modal-body">
                          Yakin ingin menghapus transaksi ini?
                          <br><br>
                          <input type="hidden" name="idt" value="<?= $id; ?>">
                          <div class="modal-footer">
                            <button type="submit" class="btn btn-danger" name="hapusTransaksi">Hapus</button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              <?php
              };
              ?>
            </tbody>
          </table>
          <!-- END TABEL TRANSAKSI MASUK -->
        </div>
      </div>
    </div>
  </div>
  <!-- Modal add transaksi masuk -->
  <div class="modal fade" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Tambah Barang Masuk</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <form method="post">
          <div class="modal-body">
            <select name="listbarang" class="form-control">
              <?php
              $query = "SELECT * FROM barang JOIN jenis ON barang.id_jenis = jenis.id_jenis";
              $result = mysqli_query($koneksi, $query);
              while ($row = mysqli_fetch_assoc($result)) {
                echo '<option value="' . $row['id_barang'] . '">' . $row['barang'] . ' - ' . $row['jenis_barang'] . '</option>';
              }
              ?>
            </select>
            <br>
            <input type="number" name="jumlah" placeholder="Jumlah" class="form-control" required>
            <br>
            <label>Nama Pekerja</label>
            <input type="text" name="nama_pekerja" class="form-control" value="<?= $pekerja ?>" readonly>
            <div class="modal-footer">
              <button type="submit" class="btn bg-primary text-white" name="barangmasuk">Submit</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</main>

<!-- END TRANSAKSI MASUK PAGE -->