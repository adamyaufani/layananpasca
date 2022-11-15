<div class="row">
	<div class="col-12">

		<div class="card card-success card-outline">
		
			<div class="card-body">
				<?php
        
				if ($query) {  ?>
					<table id="surat-desc" class="table table-bordered tb-surats">
						<thead>
							<tr>						
								<th>Nama</th>
								<th>Nomor Mahasiswa</th>
								<th>Tanggal Yudisium</th>							
								<th>IPK</th>							
								<th>Lama Studi</th>							
								<th>Predikat</th>							
							</tr>
						</thead>
						<tbody>
							<?php
							foreach ($query as $yudisium) {  ?>
								<tr>
									<td>
										<a class="judul" href="<?= base_url('admin/yudisium/detail/' . encrypt_url($yudisium['id'])); ?>"><?= $yudisium['fullname']; ?></a>
									</td>
									<td><?php echo $yudisium['username']; ?></td>									
									<td><?= $yudisium['tanggal_yudisium'];	?></td>
									<td><?= $yudisium['ipk'];	?></td>
									<td><?= $yudisium['lama_tahun'];	?> tahun, <?= $yudisium['lama_bulan'];	?>, bulan, <?= $yudisium['lama_hari'];	?> hari</td>
									<td><?= $yudisium['predikat'];	?></td>
									</td>
								</tr>
							<?php } ?>
						</tbody>
						</tfoot>
					</table>
				<?php } else { ?>

					<p class="lead">Belum ada data.</p>

				<?php }
				?>
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
<!-- <script src="<?= base_url() ?>/public/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>/public/vendor/datatables/dataTables.bootstrap4.min.js"></script> -->

<script>
	$(document).ready(function() {
		$('#surat').DataTable({

			<?php if ($this->session->userdata('role') == 1) { ?> "order": [
					[1, "asc"]
				]
			<?php } ?>
			<?php if ($this->session->userdata('role') == 5) { ?> "order": [
					[1, "desc"]
				]
			<?php } ?>


		});
	});
</script>