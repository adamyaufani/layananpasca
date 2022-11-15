<div class="row">
	<div class="col-12">

		<div class="card card-success card-outline">
			<div class="card-header">
      <a class="btn btn-sm btn-success p-2" style="border-radius:30px;" href="<?= base_url("admin/suratmasuk/baru"); ?>"><i class="fas fa-fw fa-plus"></i> Surat Masuk Baru</a>
			</div>
			<div class="card-body">			
					<table id="surat-desc" class="table table-bordered tb-surats">
						<thead>
							<tr>
								<th style="width:50%">Perihal</th>
								<th>Pembuat</th>
								<th>Tanggal Masuk</th>
								<th>Disposisi</th>
							</tr>
						</thead>
						<tbody>
							<?php
							foreach ($query as $surat) {  ?>
								<tr>
									<td>
										<a class="judul" href="<?= base_url('admin/suratmasuk/detail/' . encrypt_url($surat['id_surat_masuk'])); ?>"><?= $surat['hal']; ?></a>
									</td>
									<td><?php echo $surat['pengirim']; ?></td>
									<td><?php echo $surat['created_at']; ?></td>
									<td><?php echo $surat['disposisi']; ?></td>								
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