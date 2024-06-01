<!-- ACTION BUTTON -->
<td>
  <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#edit<?= $id; ?>">Edit</button>
  <?php if ($role == 'Kepala') : ?>
    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete<?= $id; ?>">Hapus</button>
  <?php endif; ?>
</td>

<!-- END ACTION BUTTON -->