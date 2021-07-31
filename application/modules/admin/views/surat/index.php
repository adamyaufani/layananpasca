<div class="row">
	<div class="col-12">

		<!-- fash message yang muncul ketika proses penghapusan data berhasil dilakukan -->
		<?php if ($this->session->flashdata('msg') != '') : ?>
		<div class="alert alert-success flash-msg alert-dismissible">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			<h4>Sukses!</h4>
			<?= $this->session->flashdata('msg'); ?>
		</div>
		<?php endif; ?>

		<div class="card card-success card-outline">
			<div class="card-header">
				<a class="nav-s text-danger" href="<?= base_url("admin/surat/index/" . $this->session->userdata('role')); ?>">
					<i class="fas fa-fw fa-exclamation-circle"></i> Tampilkan yang perlu diproses</a>
				</a>&nbsp;
				<a class=" nav-lilk" href="<?= base_url("admin/surat/index/"); ?>">
					<i class="fas fa-fw fa-envelope"></i> Tampilkan semua surat</a>
			</div>
			<div class="card-body">
				<?php
				if ($query) {  ?>
					<table id="surat-desc" class="table table-bordered tb-surats">
						<thead>
							<tr>
								<th style="width:40%">Perihal</th>
								<th style="width:20%">Status</th>
								<th>Pembuat</th>
								<th>Prodi</th>
								<th>Tanggal</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
							<?php
							foreach ($query as $surat) {  ?>
								<tr class="<?= ($surat['id_status'] == 2) ? 'proses' : ''; ?> <?= ($surat['id_status'] == 4) ? 'perlu-revisi' : ''; ?>">
									<td>
										<a class="judul" href="<?= base_url('admin/surat/detail/' . encrypt_url($surat['id_surat'])); ?>"><?= $surat['kategori_surat']; ?></a>
									</td>
									<td class="table-<?= $surat['badge']; ?>"><?php echo $surat['status']; ?></td>
									<td>
										<p class="m-0"><?= $surat['fullname']; ?></p>										
									</td>
									<td>
										<p class="m-0"><?= $surat['prodi']; ?></p>										
									</td>
									
									<td>
										<p class="m-0"><?= $surat['date_full'];	?></p>
										<p class="badge m-0 badge-warning"><?= $surat['time']; ?></p>
									</td>
									<td class="text-center">
											<?php if($surat['id_status'] != 20) { ?>
												<a href="" style="color:#fff;" title="Hapus"
												class="delete btn btn-sm  btn-circle btn-danger"
												data-href="<?= base_url('admin/surat/hapus/d/' . $surat['id_surat']); ?>"
												data-toggle="modal" data-target="#confirm-delete"> <i
													class="fa fa-trash-alt"></i></a>
											<?php } else { ?>
												<a href="<?= base_url('admin/surat/hapus/r/' . $surat['id_surat']); ?>" style="color:#fff;" title="Kembalikan"
												class="restore btn btn-sm  btn-circle btn-success"> <i
													class="fa fa-undo"></i></a>
											<?php } ?>
									</td>
								</tr>
							<?php } ?>
						</tbody>
						</tfoot>
					</table>
				<?php } else { ?>

					<p class="lead">Saat ini belum ada surat yang perlu diproses</p>

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
<script src="<?= base_url() ?>/public/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>/public/vendor/datatables/dataTables.bootstrap4.min.js"></script>

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