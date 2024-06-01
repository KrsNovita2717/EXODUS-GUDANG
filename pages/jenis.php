<!-- JENIS PAGE -->
<main>
  <div class="container-fluid">
    <h1 class="mt-4">Jenis Barang</h1>
    <div class="card mb-4">
      <div class="card-header">
        <button type="button" class="btn bg-primary text-white" data-toggle="modal" data-target="#myModal"> Tambah Jenis </button>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <!-- TABEL JENIS -->
          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>No</th>
                <th>Jenis Barang</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $listjenis = mysqli_query($koneksi, "select * from jenis");
              $i = 1;
              while ($data = mysqli_fetch_array($listjenis)) {
                $id = $data['id_jenis'];
                $jenis = $data['jenis_barang'];
              ?>
                <tr>
                  <td><?= $i++; ?></td>
                  <td><?= $jenis; ?></td>
                  <?php include './components/action_button.php'; ?>
                </tr>
                <!-- Modal edit table jenis -->
                <div class="modal fade" id="edit<?= $id; ?>">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title">Edit Jenis</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                      </div>
                      <form method="post">
                        <div class="modal-body">
                          <input type="text" class="form-control" name="jenis" value="<?= $jenis; ?>"> <br>
                          <br>
                          <input type="hidden" name="idj" value="<?= $id; ?>">
                          <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" name="updatejenis">Edit</button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
                <!-- Modal delete table jenis -->
                <div class="modal fade" id="delete<?= $id; ?>">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title">Delete Jenis Barang</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                      </div>
                      <form method="post">
                        <div class="modal-body">
                          Yakin ingin menghapus jenis <?= $jenis; ?>?
                          <br><br>
                          <input type="hidden" name="idj" value="<?= $id; ?>">
                          <div class="modal-footer">
                            <button type="submit" class="btn btn-danger" name="hapusjenis">Hapus</button>
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
          <!-- END TABEL JENIS -->
        </div>
      </div>
    </div>
  </div>
  <!-- Modal add table distributor -->
  <div class="modal fade" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Tambah Jenis Barang</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <form method="post">
          <div class="modal-body">
            <input type="text" name="jenis" placeholder="Jenis Barang" class="form-control" required>
            <br>
            <div class="modal-footer">
              <button type="submit" class="btn bg-primary text-white" name="submitjenis">Submit</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</main>

<!-- END TABEL JENIS -->