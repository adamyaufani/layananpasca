<div class="row">
  <div class="col-8 offset-md-2">
    <div class="card">
      <div class="card-body">
        <table id="datatable-descs" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th style="width:50%">Subyek</th>
              <th class="text-center">Tanggal</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($notif->result_array() as $row) {  ?>
              <tr class="<?= ($row['status'] == 1) ? 'light' : 'table-danger'; ?>">
                <td><a class="font-weight-bold text-dark" href=" <?= base_url('notif/detail/' . $row['notif_id']); ?>"><?= $row['judul_notif']; ?></a></td>
                <td class=" text-center">
                <?= $row['date_full'];  ?> <?= $row['time']; ?>
                </td>
              </tr>
            <?php } ?>
          </tbody>
          </tfoot>
        </table>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.col -->
</div>
<!-- /.row -->