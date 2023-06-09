<h1 class="h3 mb-4 text-gray-900"><?= $surat['kategori_surat']; ?> </h1>

<div class="row">
	<div class="<?= ($surat['id_status'] == 1) ? "col-md-12" : "col-md-8" ?> mb-4">
		<?php if( $surat['id_status'] == 9 ) { ?>
			<a href="<?= base_url('admin/surat/detail/'. encrypt_url($surat['id'])); ?>" class="btn btn-warning btn-lg btn-block mb-4">Klik untuk memproses surat</a>
		<?php } ?>
		<div class="card shadow">
			<a href="#collKeterangan" class="d-block card-header pt-3 pb-2 bg-abumuda <?= ($surat['id_status'] == 10) ? "collapsed" : "" ?>" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collKeterangan">
				<p class="h6 font-weight-bold text-white">Keterangan</p>
			</a>
			<div class="collapse<?= ($surat['id_status'] == 10) ? "" : " show" ?>" id="collKeterangan">
				<div class="card-body">

					<?php echo form_open(base_url('admin/surat/tambah/' . encrypt_url($surat['id'])), '') ?>

					<input type="hidden" name="id_surat" value="<?= $surat['id']; ?>">
					<input type="hidden" name="id_notif" value="<?= $surat['id_notif']; ?>">
					<?php
					if ($fields) {
					
						foreach ($fields as $field) {

							$type = $field['type'];
							$kat_keterangan_surat = $field['kat_keterangan_surat']; ?>

							<div class="form-group row">
								<label class="<?= ($surat['id_status'] == 1) ? "col-md-2" : "col-md-5" ?>" for="dokumen[<?= $field['id']; ?>]"><?= $kat_keterangan_surat; ?> <?= ($field['required'] == 1) ? '<sup class="badge badge-danger badge-counter">Wajib</sup>': ''; ?>
									<small id="emailHelp" class="form-text text-muted"><?= $field['deskripsi']; ?></small>

								</label>
								<div class="<?= ($surat['id_status'] == 1) ? "col-md-10" : "col-md-7" ?>">
									<?php generate_form_field($field['id'], $surat['id'], $surat['id_status'], '', $surat['id_kategori_surat'] ); ?>
								</div>
							</div>

					<?php }
					} ?>

					<?php if ($surat['id_status'] == 4) { ?>
						<input type="hidden" name="revisi" value="1">
						<input class="btn btn-lg btn-<?= $surat['badge']; ?> btn-block" type="submit" name="submit" value="<?= ($surat['id_status'] == '4') ? "Kirim Revisi Data" : "Ajukan Surat " . $surat['kategori_surat']; ?>" />

					<?php } elseif ($surat['id_status'] == 1) { ?>
						<input class="btn btn-lg btn-<?= $surat['badge']; ?> btn-block" type="submit" name="submit" value="Ajukan Surat <?= $surat['kategori_surat']; ?>" />
					<?php } ?>

					<?php echo form_close(); ?>
				</div>
			</div>

		</div>
		<?php if ($surat['id_status'] == 10) { ?>
			<div class="card shadow mt-3">
				<a href="#collterbit" class="d-block card-header pt-3 pb-2 bg-success" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collterbit">
					<p class="h6 font-weight-bold text-white">Surat</p>
				</a>
				<div class="collapse show" id="collterbit">
					<div class="card-body pb-3">
						Download Surat

						<a href="<?= base_url("public/documents/pdfdata/" . $no_surat_final['file']); ?>" class="btn btn-success"> <i class="fas fa-file-pdf"></i> PDF</a>
					</div>
				</div>
			</div>
		<?php } ?>
	</div>

	<?php if ($surat['id_status'] != 1) { ?>
	<div class="col-md-4">
		<div class="card shadow">
			<a href="#collStatus" class="d-block card-header pt-3 pb-2 bg-<?= $surat['badge']; ?>" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collStatus">
				<p class="h5 text-center font-weight-bold text-white"> <?= $surat['status']; ?> </p>
			</a>
			<div class="collapse show" id="collStatus">
				<div class="card-body pl-2">

					<div class="timeline timeline-xs">
						<?php foreach ($timeline as $tl) { ?>
							<div class="timeline-item <?= ($tl['id_status'] === 7 || $tl['id_status'] === 9) ? 'd-none' : '' ?>">
								<div class="timeline-item-marker">
									<div class="timeline-item-marker-text"><?= $tl['date']; ?></div>
									<div class="timeline-item-marker-indicator bg-<?= $tl['badge']; ?>"></div>
								</div>
								<div class="timeline-item-content">
									<?= $tl['status']; ?>
									<span class="badge badge-perak"><?= $tl['time']; ?></span>
								</div>
							</div>
						<?php } ?>
					</div>

				</div>
			</div>
		</div>
	</div>
	<?php } ?>
	<!-- /.col -->
</div>

<?php call_scripts(); ?>
