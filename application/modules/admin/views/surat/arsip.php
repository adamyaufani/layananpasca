<div class="row">
	<div class="col-12">

		<div class="card card-success card-outline">
			<div class="card-header">
				Filter
			</div>
			<div class="card-body">
				
					<table id="arsip" class="table table-bordered tb-surats">
						<thead>
							<tr>
								<th>No Surat</th>
								<th style="width:20%">Perihal</th>
                <th>Tujuan Surat</th>
								<th>Pembuat</th>								
								<th>Program Studi</th>
								<th>Diterbitkan</th>
							</tr>
						</thead>
						<tbody>
							<?php
							foreach ($query as $surat) {  ?>
								<tr>
									<td>
										<a class="judul" href="<?= base_url('admin/surat/detail/' . encrypt_url($surat['id_surat'])); ?>"><?= $surat['no_lengkap']; ?></a>
									</td>							
									<td>
										<a class="judul" href="<?= base_url('admin/surat/detail/' . encrypt_url($surat['id_surat'])); ?>"><?= $surat['kategori_surat']; ?></a>
									</td>							
									<td>
										<p class="m-0"><?=  $surat['kat_tujuan_surat'];  ?></p>
									</td>
									<td>
										<p class="m-0"><?= $surat['fullname']; ?></p>
									</td>
									<td>
										<p class=""><?= $surat['prodi']; ?></p>
									</td>
									<td>
										<p class="m-0"><?= $surat['tanggal_terbit'];	?></p>
									</td>
									</td>
								</tr>
							<?php } ?>
						</tbody>
						</tfoot>
					</table>
				
			</div><!-- /.card-body -->
		</div><!-- /.card -->
	</div>
	<!-- /.col -->
</div>
<!-- /.row -->


<div class="modal fade" id="confirm-delete">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Perhatian</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Tutuo">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<p>Yakin ingin menghapus data ini?&hellip;</p>
			</div>
			<div class="modal-footer justify-content-between">
				<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
				<a class="btn btn-danger btn-ok">Hapus</a>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->



<!-- DataTables -->
<script src="<?= base_url() ?>/public/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>/public/vendor/datatables/dataTables.bootstrap4.min.js"></script>

<script>
  //---------------------------------------------------
  var table = $('#arsip').DataTable( {
    "processing": true,
    "serverSide": false,
    "ajax": "<?=base_url('admin/surat/advance_datatable_json')?>",
    "order": [[4,'desc']],
    "columnDefs": [
    { "targets": 0, "name": "id", 'searchable':true, 'orderable':true},
    { "targets": 1, "name": "username", 'searchable':true, 'orderable':true},
    { "targets": 2, "name": "email", 'searchable':true, 'orderable':true},
    { "targets": 3, "name": "mobile_no", 'searchable':true, 'orderable':true},
    { "targets": 4, "name": "created_at", 'searchable':false, 'orderable':false},
    { "targets": 5, "name": "is_active", 'searchable':true, 'orderable':true},
    ]
  });

  //---------------------------------------------------
  function user_filter()
  {
    var _form = $("#user_search").serialize();
    $.ajax({  
      data: _form,
      type: 'post',
      url: '<?php echo base_url();?>admin/example/search',
      async: true,
      success: function(output){
        table.ajax.reload( null, false );
      }
    });
  }
</script>
