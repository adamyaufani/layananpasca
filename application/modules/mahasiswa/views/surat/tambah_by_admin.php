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

					<?php echo form_open(base_url('mahasiswa/surat/tambah_by_admin/' . encrypt_url($surat['id']) . '/' . $surat['id_mahasiswa']), '') ?>

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

						<a href="<?= base_url("public/documents/pdfdata/" . $no_surat_final['file']); ?>" class="btn btn-success"> <i class="fas fa-file-pdf"></i> PDF</a>
					</div>
				</div>
			</div>
		<?php } ?>
	</div>
	<div class="col-md-4">

	<?php if($_SESSION['role'] == 2) { ?>
	<div class="card shadow mb-4">
			<a href="#collMhs" class="d-block card-header pt-3 pb-2 bg-warning" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collMhs">
				<p class="h6 font-weight-bold text-white">Pemohon</p>
			</a>
			<div class="collapse show" id="collMhs">
				<div class="card-body pb-3">
					<div class="media">

						<?= profPic($surat['username'], 60); ?>

						<div class="media-body ml-2">
							<h5 class="mt-0 text-gray-900 mb-0 font-weight-bold"><?= $surat['fullname']; ?></h5>
							<span class="mb-0 badge badge-ijomuda"> <?= $surat['username']; ?></span>
							<p class="mb-0 text-gray-800"> <?= $surat['prodi']; ?></p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php } ?>

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