<!-- DASHBOARD PAGE -->
<main>
  <div class="container-fluid">
    <h1 class="mt-4">Dashboard</h1>
    <div class="card mb-4">
      <div class="card-header">
        <button type="button" class="btn bg-primary text-white" data-toggle="modal" data-target="#myModal"> Tambah Stok </button>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <!-- TABEL BARANG -->
          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr align="center">
                <th>No</th>
                <th>Nama Barang</th>
                <th>Jenis</th>
                <th>Jumlah Stok</th>
                <th>Distributor</th>
                <th>Opsi</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $listbarang = mysqli_query($koneksi, "SELECT * FROM barang b, jenis j, distributor d WHERE b.id_jenis=j.id_jenis AND b.id_distributor=d.id_distributor");
              $i = 1;
              while ($data = mysqli_fetch_array($listbarang)) {
                $namabarang = $data['barang'];
                $jenis = $data['jenis_barang'];
                $idj = $data['id_jenis'];

                $stok = $data['stok_tersedia'];
                $id = $data['id_barang'];
                $distrib = $data['nama_distributor'];
              ?>
                <tr align="center">
                  <td><?= $i++; ?></td>
                  <td><?= $namabarang; ?></td>
                  <td><?= $jenis; ?></td>
                  <td><?= $stok; ?></td>
                  <td><?= $distrib; ?></td>
                  <?php include './components/action_button.php'; ?>
                </tr>
                <!-- Modal edit table barang -->
                <div class="modal fade" id="edit<?= $id; ?>">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title">Edit Barang</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                      </div>
                      <form method="post">
                        <div class="modal-body">
                          <?php if ($role == 'Kepala') : ?>
                            <input type="text" name="namabarang" class="form-control" value="<?= $namabarang; ?>">
                          <?php else : ?>
                            <div class="form-control"><?= $namabarang; ?></div>
                            <input type="hidden" name="namabarang" value="<?= $namabarang; ?>">
                          <?php endif; ?>
                          <br>
                          <select name="listdesc" class="form-control">
                            <?php
                            $query = mysqli_query($koneksi, "SELECT * FROM jenis");
                            while ($data = mysqli_fetch_array($query)) {
                              $selected = "";
                              if ($data['id_jenis'] == $idj) {
                                $selected = "selected";
                              }
                              echo "<option value='" . $data['id_jenis'] . "' " . $selected . ">" . $data['jenis_barang'] . "</option>";
                            }
                            ?>
                          </select>
                          <br>
                          <input type="hidden" name="idb" value="<?= $id; ?>">
                          <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" name="updatebarang">Edit</button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>

                <!-- Modal delete table barang -->
                <div class="modal fade" id="delete<?= $id; ?>">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title">Delete Barang</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                      </div>
                      <form method="post">
                        <div class="modal-body">
                          Yakin ingin menghapus <?= $namabarang ?>?
                          <br> <br>
                          <input type="hidden" name="idb" value="<?= $id; ?>">
                          <div class="modal-footer">
                            <button type="submit" class="btn btn-danger" name="hapusbarang">Hapus</button>
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
          <!-- END TABEL BARANG -->
        </div>
      </div>
    </div>
  </div>

  <!-- tambah data table barang -->
  <div class="modal fade" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Tambah Barang</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <form method="post">
          <div class="modal-body">
            <input type="text" name="namabarang" placeholder="nama barang" class="form-control" required>
            <br>
            <select name="listdesc" class="form-control">
              <?php
              $ambildata = mysqli_query($koneksi, "select * from jenis");
              while ($fetcharray = mysqli_fetch_array($ambildata)) {
                $id_jenis = $fetcharray['id_jenis'];
                $jenis_barang = $fetcharray['jenis_barang'];
              ?>
                <option value="<?= $id_jenis; ?>"><?= $jenis_barang; ?></option>
              <?php
              }
              ?>
            </select>
            <br>
            <select name="distributor" class="form-control">
              <?php
              $ambildata = mysqli_query($koneksi, "select * from distributor");
              while ($fetcharray = mysqli_fetch_array($ambildata)) {
                $id_distributor = $fetcharray['id_distributor'];
                $distributor = $fetcharray['nama_distributor'];
              ?>
                <option value="<?= $id_distributor; ?>"><?= $distributor; ?></option>
              <?php
              }
              ?>
            </select>
            <br>
            <input type="number" name="stok" placeholder="stok" class="form-control" required>
            <div class="modal-footer">
              <button type="submit" class="btn bg-primary text-white" name="submit">Submit</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</main>

<!-- END DASHBOARD PAGE -->