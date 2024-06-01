<!-- PEKERJA PAGE -->
<main>
  <div class="container-fluid">
    <h1 class="mt-4">Pekerja</h1>
    <div class="card mb-4">
      <div class="card-header">
        <button type="button" class="btn bg-primary text-white" data-toggle="modal" data-target="#myModal"> Tambah Pekerja </button>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <!-- TABEL PEKERJA -->
          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr align="center">
                <th>No</th>
                <th>Nama Pekerja</th>
                <th>No Telepon</th>
                <th>Alamat</th>
                <th>Posisi</th>
                <th>Opsi</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $listpekerja = mysqli_query($koneksi, "select * from pekerja");
              $i = 1;
              while ($data = mysqli_fetch_array($listpekerja)) {
                $nama = $data['nama_pekerja'];
                $alamat = $data['alamat_pekerja'];
                $notelp = $data['no_telp'];
                $id = $data['id_pekerja'];
                $posisi = $data['jabatan'];
                $notelpLink = str_replace(["-", " "], "", $notelp);
                if (substr($notelpLink, 0, 2) != "62") {
                  $notelpLink = "62" . $notelpLink;
                }
                $whatsappLink = "https://wa.me/$notelpLink";
              ?>
                <tr align="center">
                  <td><?= $i++; ?></td>
                  <td><?= $nama; ?></td>
                  <td><a href="<?= $whatsappLink; ?>" target="_blank"><?= $notelp; ?></a></td>
                  <td><?= $alamat; ?></td>
                  <td><?= $posisi; ?></td>
                  <?php include './components/action_button.php'; ?>
                </tr>
                <!-- Modal edit table pekerja -->
                <div class="modal fade" id="edit<?= $id; ?>">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title">Edit Pekerja</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                      </div>
                      <form method="post">
                        <div class="modal-body">
                          <input type="text" class="form-control" name="nama" value="<?= $nama; ?>"> <br>
                          <input type="text" class="form-control" name="alamat" value="<?= $alamat; ?>"> <br>
                          <input type="text" class="form-control" name="no_telp" value="<?= $notelp; ?>"> <br>
                          <select name="jabatan" class="form-control">
                            <option value="Kepala" <?= ($posisi == 'Kepala') ? 'selected' : ''; ?>>Kepala</option>
                            <option value="Admin" <?= ($posisi == 'Admin') ? 'selected' : ''; ?>>Admin</option>
                          </select>
                          <br>
                          <input type="hidden" name="idpk" value="<?= $id; ?>">
                          <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" name="updatepekerja">Edit</button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>

                <!-- Modal delete table pekerja -->
                <div class="modal fade" id="delete<?= $id; ?>">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title">Hapus Pekerja</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                      </div>
                      <form method="post">
                        <div class="modal-body">
                          Yakin ingin menghapus <?= $nama ?>?
                          <br> <br>
                          <input type="hidden" name="idpk" value="<?= $id; ?>">
                          <div class="modal-footer">
                            <button type="submit" class="btn btn-danger" name="hapuspekerja">Hapus</button>
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
          <!-- END TABEL PEKERJA -->
        </div>
      </div>
    </div>
  </div>
  <!-- Modal add table pekerja -->
  <div class="modal fade" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Tambah Pekerja</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <form method="post">
          <div class="modal-body">
            <input type="text" name="nama" placeholder="Nama pekerja" class="form-control" required> <br>
            <input type="text" name="alamat" placeholder="Alamat" class="form-control" required> <br>
            <input type="text" name="no_telp" placeholder="Nomor Telepon" class="form-control" required><br>
            <select name="jabatan" class="form-control" required>
              <option value="" disabled selected>Pilih Posisi</option>
              <option value="Kepala">Kepala</option>
              <option value="Admin">Admin</option>
            </select><br>
            <div class="modal-footer">
              <button type="submit" class="btn bg-primary text-white" name="submitpekerja">Submit</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</main>

<!-- END PEKERJA PAGE -->