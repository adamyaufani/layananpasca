<style>
	@keyframes bounce {

		0%,
		100%,
		20%,
		50%,
		80% {
			-webkit-transform: translateY(0);
			-ms-transform: translateY(0);
			transform: translateY(0)
		}

		40% {
			-webkit-transform: translateY(-30px);
			-ms-transform: translateY(-30px);
			transform: translateY(-30px)
		}

		60% {
			-webkit-transform: translateY(-15px);
			-ms-transform: translateY(-15px);
			transform: translateY(-15px)
		}
	}

	.feedback {
		-webkit-animation-duration: 1s;
		animation-duration: 1s;
		-webkit-animation-fill-mode: both;
		animation-fill-mode: both;
		-webkit-animation-timing-function: ease-in-out;
		animation-timing-function: ease-in-out;
		animation-iteration-count: infinite;
		-webkit-animation-iteration-count: infinite;
		color: white;
	}

	.feedback:hover {
		cursor: pointer;
		animation-name: bounce;
		-moz-animation-name: bounce;
	}
	.opacity {
		opacity: 0.6;
	}
</style>

<h1 class="h3 mb-4 text-gray-900"><?= $surat['kategori_surat']; ?> </h1>

<div class="row">
	<div class="col-md-8 mb-4">
		<div class="card shadow">
			<a href="#collKeterangan" class="d-block card-header pt-3 pb-2 bg-abumuda <?= ($surat['id_status'] == 10) ? "collapsed" : "" ?>" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collKeterangan">
				<p class="h6 font-weight-bold text-white">Keterangan</p>
			</a>
			<div class="collapse<?= ($surat['id_status'] == 10) ? "" : " show" ?>" id="collKeterangan">
				<div class="card-body">

					<?php echo form_open(base_url('mahasiswa/surat/tambah/' . encrypt_url($surat['id'])), '') ?>

					<input type="hidden" name="id_surat" value="<?= $surat['id']; ?>">
					<input type="hidden" name="id_notif" value="<?= $surat['id_notif']; ?>">
					<?php

				
					if ($fields) {

						foreach ($fields as $field) {

							$type = $field['type'];
							$kat_keterangan_surat = $field['kat_keterangan_surat']; ?>

							<div class="form-group row">
								<label class="col-md-5" for="dokumen[<?= $field['id']; ?>]"><?= $kat_keterangan_surat; ?>
									<small id="emailHelp" class="form-text text-muted"><?= $field['deskripsi']; ?></small>

								</label>
								<div class="col-md-7">
									<?php generate_form_field($field['id'], $surat['id'], $surat['id_status']); ?>
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

						<a href="<?= base_url("mahasiswa/surat/cetak_surat/" . encrypt_url($surat['id'])); ?>" class="btn btn-success"> <i class="fas fa-file-pdf"></i> PDF</a>
					</div>
				</div>
			</div>
		<?php } ?>
	</div>
	<div class="col-md-4">

		<div class="card shadow">
			<a href="#collStatus" class="d-block card-header pt-3 pb-2 bg-<?= $surat['badge']; ?>" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collStatus">
				<p class="h5 text-center font-weight-bold text-white"> <?= $surat['status']; ?> </p>
			</a>
			<div class="collapse show" id="collStatus">
				<div class="card-body pl-2">
					<?php if ($surat['id_status'] == 10) {
						if ($sudah_survey == 1) { 
							?>

							<div class="px-5 py-2 mb-4">
								<div class="row">
								<div class="col-12 text-center">
										<p>Terima kasih feedbacknya.</p>
									</div>
									<div class="col-4 text-center"> 
										<img class="img-thumbnail rounded-circle <?= $hasil_survey['answer'] == 3 ? "border-warning":"border-0 opacity"; ?>" title="Tidak Puas" data-toggle="tooltip" data-placement="top" width="70" src="<?= base_url(); ?>public/dist/img/sad.png">
									</div>
									<div class="col-4 text-center">
										<img class="img-thumbnail rounded-circle <?= $hasil_survey['answer'] == 2 ? "border-warning":"border-0 opacity"; ?>" title="Puas" width="70" src="<?= base_url(); ?>public/dist/img/happy.png">
									</div>
									<div class="col-4 text-center">
										<img class="img-thumbnail rounded-circle <?= $hasil_survey['answer'] == 1 ? "border-warning":"border-0 opacity"; ?>" title="Sangat Puas" width="70" src="<?= base_url(); ?>public/dist/img/veryhappy.png">
									</div>
								</div>
							</div>

						<?php } else {
						?>
							
							<div class="px-5 py-2 mb-4" id="feedback">
								<div class="row">
									<div class="col-12 text-center">
									<p class="p-feedback">Berikan feedbackmu untuk SIM Layanan Pasca.</p>
									</div>
									<div class="col-4 text-center">
										<img data-id="3" class="feedback fb-3 img-thumbnail rounded-circle border-0" title="Tidak Puas" data-toggle="tooltip" data-placement="top" width="70" src="<?= base_url(); ?>public/dist/img/sad.png">
									</div>
									<div class="col-4 text-center">
										<img data-id="2" class="feedback fb-2 img-thumbnail rounded-circle border-0" title="Puas" width="70" src="<?= base_url(); ?>public/dist/img/happy.png">
									</div>
									<div class="col-4 text-center">
										<img data-id="1" class="feedback fb-1 img-thumbnail rounded-circle border-0" title="Sangat Puas" width="70" src="<?= base_url(); ?>public/dist/img/veryhappy.png">
									</div>
								</div>
							</div>

					<?php } // endif blm survey
					} // endif status 10 
					?>
					<?php if ($surat['catatan']) { ?>
						<div class="alert alert-ijomuda ml-3 pb-0">
							<p class="m-0"><i class="fas fa-comment-dots"></i> <strong>Catatan dari Tata Usaha</strong></p>
							<hr class="mt-2 mb-3" style="border:1px dashed #b2e4b2">
							<p><?= $surat['catatan']; ?></p>
						</div>
					<?php } ?>

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
	<!-- /.col -->
</div>

<script>
	$(document).ready(function() {
		$('.feedback').on('click', function() {

			var id = $(this).data('id');
			var SITEURL = "<?= base_url(); ?>";

			$.ajax({
				url: SITEURL + "mahasiswa/surat/feedback/<?= $surat['id']; ?>",
				data: {
					answer: id,
				},
				type: "post",
				dataType: 'json',
				success: function(res) {

					if(res.status == 'sukses') {
						$('p.p-feedback').html('Terima kasih feedbacknya.')
						$('.fb-' + res.answer).addClass('border-warning');
						$('.fb-' + res.answer).removeClass('border-0');
						$('#feedback').find('img').removeClass('feedback');
						$('#feedback').find('img.border-0').addClass('opacity');
					} else {
						$('p.p-feedback').html('Kamu sudah ngasih feedback. Cukup 1x aja.')
					}
					
				},
				error: function(data) {
					console.log('Error:', data);
				}
			});

		});
	});
</script>