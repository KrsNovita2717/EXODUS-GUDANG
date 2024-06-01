<!-- DISTRIBUTOR PAGE -->
<main>
  <div class="container-fluid">
    <h1 class="mt-4">Distributor</h1>
    <div class="card mb-4">
      <div class="card-header">
        <button type="button" class="btn bg-primary text-white" data-toggle="modal" data-target="#myModal"> Tambah distributor </button>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <!-- TABEL DISTRIBUTOR -->
          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr align="center">
                <th>No</th>
                <th>Nama Distributor</th>
                <th>Alamat</th>
                <th>No Telepon</th>
                <th>Opsi</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $listdistrib = mysqli_query($koneksi, "select * from distributor");
              $i = 1;
              while ($data = mysqli_fetch_array($listdistrib)) {
                $nama = $data['nama_distributor'];
                $alamat = $data['alamat_distributor'];
                $notelp = $data['no_telp'];
                $id = $data['id_distributor'];
                $notelpLink = str_replace(["-", " "], "", $notelp);
                if (substr($notelpLink, 0, 2) != "62") {
                  $notelpLink = "62" . $notelpLink;
                }
                $whatsappLink = "https://wa.me/$notelpLink";

              ?>
                <tr align="center">
                  <td><?= $i++; ?></td>
                  <td><?= $nama; ?></td>
                  <td><?= $alamat; ?></td>
                  <td><a href="<?= $whatsappLink; ?>" target="_blank"><?= $notelp; ?></a></td>
                  <?php include './components/action_button.php'; ?>
                </tr>
                <!-- Modal edit table distributor -->
                <div class="modal fade" id="edit<?= $id; ?>">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title">Edit Distributor</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                      </div>
                      <form method="post">
                        <div class="modal-body">
                          <input type="text" class="form-control" name="nama" value="<?= $nama; ?>"> <br>
                          <input type="text" class="form-control" name="alamat" value="<?= $alamat; ?>"> <br>
                          <input type="text" class="form-control" name="no_telp" value="<?= $notelp; ?>">
                          <br>
                          <input type="hidden" name="iddis" value="<?= $id; ?>">
                          <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" name="updatedistrib">Edit</button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>

                <!-- Modal delete table distributor -->
                <div class="modal fade" id="delete<?= $id; ?>">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title">Delete distributor</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                      </div>
                      <form method="post">
                        <div class="modal-body">
                          Yakin ingin menghapus <?= $nama ?>?
                          <br> <br>
                          <input type="hidden" name="iddis" value="<?= $id; ?>">
                          <div class="modal-footer">
                            <button type="submit" class="btn btn-danger" name="hapusdistrib">Hapus</button>
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
          <!-- END TABEL DISTRIBUTOR -->
        </div>
      </div>
    </div>
  </div>
  <!-- Modal add table distributor -->
  <div class="modal fade" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Tambah Distributor</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <form method="post">
          <div class="modal-body">
            <input type="text" name="nama" placeholder="Nama Distributor" class="form-control" required> <br>
            <input type="text" name="alamat" placeholder="Alamat" class="form-control" required> <br>
            <input type="text" name="no_telp" placeholder="Nomor Telepon" class="form-control" required>
            <br>
            <div class="modal-footer">
              <button type="submit" class="btn bg-primary text-white" name="submitdistrib">Submit</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</main>

<!-- END DISTRIBUTOR PAGE -->