<!-- catatan:
error message pada field jika invalidnya masih muncul, padahal field yg salah sudah diganti isinya,
mestinya ketika user mengganti, error messagenya langsung ilang -->

<style>
	.textarea-summernote.is-invalid+.note-editor {
		border: 1px solid #b0272b;
	}

	.opacity {
		opacity: 0.6;
	}

	.isi_editor {
		border: 1px solid #666666;
		border-radius: 5px;
		padding: 20px;
		width: 100%;
		height: auto;
	}
</style>



<h1 class="h3 mb-4 text-gray-900"><?= $surat['kategori_surat']; ?> <sup style="font-size:10px;"><?= $surat['id']; ?></sup></h1>



<div class="row">
	<div class="col-lg-8 mb-4">
		<?php if (isset($msg) || validation_errors() !== '') : ?>
			<div class="alert alert-danger alert-dismissible">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<h4><i class="fa fa-exclamation"></i> Terjadi Kesalahan</h4>
				<?= validation_errors(); ?>
				<?= isset($msg) ? $msg : ''; ?>
			</div>
		<?php endif; ?>
		<!-- fash message yang muncul ketika proses penghapusan data berhasil dilakukan -->
		<?php if ($this->session->flashdata('msg') != '') : ?>
			<div class="alert alert-success flash-msg alert-dismissible">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<h4>Sukses!</h4>
				<?= $this->session->flashdata('msg'); ?>
			</div>
		<?php endif; ?>


	
		<div class="card shadow">
			<a href="#collKeterangan" class="d-block card-header pt-3 pb-2 bg-abumuda " data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collKeterangan">
				<p class="h6 font-weight-bold text-white">Keterangan</p>
			</a>
			<div class="collapse show" id="collKeterangan">
				<div class="card-body">

					<?php

					echo form_open('admin/daftaryudisium/acc_yudisium');
					
					?>

					<input type="hidden" name="id_surat" value="<?= $surat['id']; ?>">
					<input type="hidden" name="id_notif" value="<?= $surat['id_notif']; ?>">

					<input type="hidden" name="sizeof_ket_surat" value="<?= count($fields); ?>">
					<input type="hidden" name="user_id" value="<?= $surat['user_id']; ?>">

					<?php
					if ($fields) {
						foreach ($fields as $field) {

							$type = $field['type'];
							$kat_keterangan_surat = $field['kat_keterangan_surat']; ?>

							<div class="form-row mb-3">
								<label class="col-lg-5" for="dokumen[<?= $field['id']; ?>]"><?= $kat_keterangan_surat; ?></label>
								<div class="col-lg-7">
									<?php
									// memanggil form (data_helper.php)
									generate_keterangan_surat($field['id'], $surat['id'], $surat['id_status'], $surat['id_kategori_surat']); ?>
								</div>
							</div>

					<?php }
					} ?>

					

					<?php 				
					if (($surat['id_status'] == 8 ) 
						&& ($this->session->userdata('role') == 1)) { 
					?>
						<div class="form-row pt-3">
							<div class="col-md-12">
								<div class="card">
									<div class="card-header">
										Hasil Verifikasi Dokumen oleh Tata Usaha Pascasarjana</b>
									</div>
									<div class="card-body">

										<p> Setelah diperiksa dengan seksama, maka
										Tata Usaha Pascasarjana menyatakan bahwa permohonan <strong>Surat <?= $surat['kategori_surat']; ?></strong> yang diajukan oleh <strong><?= $surat['fullname']; ?></strong> : </p>

										<ul class="list-group list-group-flush">
											<li class="list-group-item"><input type="radio" name="rev2" id="diterima" value="11" /> Diterima dan dapat diproses lebih lanjut
											</li>

											<li class="list-group-item"><input type="radio" name="rev2" id="ditolak" value="6" /> Ditolak

												
											<li class="list-group-item"><input type="radio" name="rev2" id="revisi" value="4" /> Perlu direvisi kembali
											</li>
									
										</ul>
										<p class="mt-4">Catatan dari Tata Usaha</p>
										<textarea class="form-control" name="catatan"></textarea>


										<p class="mt-3">
											<span class="pl-2 mb-2 d-inline-block"><input type="checkbox" name="" id="sudahPeriksa"> Pernyataan ini dibuat dengan sebenar-benarnya dan dapat dipertanggung jawabkan kebenarannya. <a class="help" data-toggle="tooltip" data-placement="top" title="Centang untuk mengaktifkan tombol verifikasi."><i class="fa fa-info-circle"></i></a></span>
										</p>


										<input type="submit" id="sub1" value="Kirim Hasil Verifikasi" name="submit" class="btn btn-<?= $surat['badge']; ?> btn-md btn-block" disabled>
									</div>


								</div>
						
							</div>
						</div>

						<script>
							$(function() {
							

									var check_all = sizeof = $("input[name='sizeof_ket_surat']").val();

									var oke = $('.verifikasi:checked').length;

									console.log(check_all);
									console.log(oke);

									// $('#diterima').click(function(e) {
									// 	if ($('.verifikasi:checked').length != check_all) {

									// 		$('#error_modal').modal("show");
									// 		return false;
									// 	}
									// });

									$('#ditolak').click(function(e) {
										// lalu cocokkan dengan fungsi dibawah ini
										// jumalh field yang dichecked harus sama dengan jumalh field
										if ($('.verifikasi:checked').length == check_all) {

											//  jika jumlah field tidak sama, maka option id="#diterima" memunculkan modal eror di bawah
											//$('#error_modal').modal("show");
											alert('sudah dicentang semua kok ditolak?');
											return false;
										}
									});

									$('#revisi').click(function(e) {
										// lalu cocokkan dengan fungsi dibawah ini
										// jumalh field yang dichecked harus sama dengan jumalh field
										if ($('.verifikasi:checked').length == check_all) {

											//  jika jumlah field tidak sama, maka option id="#diterima" memunculkan modal eror di bawah
											//$('#error_modal').modal("show");
											alert('sudah dicentang semua kok ditolak?');
											return false;
										}
									});

						

								$('#sudahPeriksa').click(function(e) {
									if ($(this).is(':checked')) {

										if (!$("input[name='rev2']:checked").val()) {
											alert('Hasil belum dipilih!');
											return false;
										} else {
											$('#sub1').removeAttr('disabled');
										}

									} else {
										$('#sub1').attr('disabled', 'disabled');
									}
								});
							});
						</script>
					<?php } 


					if ($surat['id_status'] == 4 && ( $this->session->userdata('role') == 1 || $this->session->userdata('role') == 2  )) { ?>
						<div class="form-row pt-3">
							<div class="col-md-12">
								<input type="submit" id="sub1" value="Menunggu revisi" name="submit" class="btn btn-perak btn-md btn-block" disabled>
							</div>
						</div>
					<?php }

					form_close(); ?>
				</div>
			</div>
		</div>




	</div>
	<!-- /.col -->
	<div class="col-lg-4">
		<div class="card shadow">
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
		<div class="card shadow mt-3">
			<a href="#collStatus" class="d-block card-header pt-3 pb-2 bg-<?= $surat['badge']; ?>" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collStatus">
				<p class="h5 text-center font-weight-bold text-white"> <?= $surat['status']; ?><sup><?= $surat['id_status']; ?></sup> </p>
			</a>
			<div class="collapse show" id="collStatus">
				<div class="card-body pl-2">
					<?php
					if (($surat['id_status'] == 10) && ($surat['klien'] != 'p')) {
						if ($sudah_survey == 1) {
					?>

							<div class="px-5 py-2 mb-4">
								<div class="row">
									<div class="col-12 text-center">
										<p>Feedback dari Mahasiswa.</p>
									</div>
									<div class="col-4 text-center">
										<img class="img-thumbnail rounded-circle <?= $hasil_survey['answer'] == 3 ? "border-warning" : "border-0 opacity"; ?>" title="Tidak Puas" data-toggle="tooltip" data-placement="top" width="70" src="<?= base_url(); ?>public/dist/img/sad.png">
									</div>
									<div class="col-4 text-center">
										<img class="img-thumbnail rounded-circle <?= $hasil_survey['answer'] == 2 ? "border-warning" : "border-0 opacity"; ?>" title="Puas" width="70" src="<?= base_url(); ?>public/dist/img/happy.png">
									</div>
									<div class="col-4 text-center">
										<img class="img-thumbnail rounded-circle <?= $hasil_survey['answer'] == 1 ? "border-warning" : "border-0 opacity"; ?>" title="Sangat Puas" width="70" src="<?= base_url(); ?>public/dist/img/veryhappy.png">
									</div>
								</div>
							</div>

						<?php } else {
						?>
							<!-- <p class="ml-2">Belum ada feedback dari Mahasiswa.</p> -->


					<?php } // endif blm survey
					} // endif status 10 
					?>

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
									<?php if($tl['catatan']) { ?>
										<div class="alert alert-ijomuda mt-3 mb-0 p-2 pl-3">
											<i class="fas fa-comment-dots"></i> <?= $tl['catatan']; ?>
										</div>
									<?php } ?>
								</div>
							</div>
						<?php } ?>
					</div>

				</div>
			</div>
		</div>

		<?php
		/*
		 if ($surat['id_kategori_surat'] == 6) {
			if (($surat['id_status'] == 1) || ($surat['id_status'] == 4)) { ?>
				<div class="card shadow mt-3">
					<a href="#collStatus" class="d-block card-header pt-3 pb-2 bg-ungutua" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collStatus">
						<p class="h5 text-center font-weight-bold text-white"> Ambil Alih </p>
					</a>
					<div class="collapse show" id="collStatus">
						<div class="card-body pl-3 text-center">
							<p class="text-center">TU dapat mengambil alih proses pengisian data <strong>jika ada kasus khusus</strong>, seperti mahasiswa kesulitan login, tidak bisa mengisi, dll.</p>

							<a class="btn btn-ungutua btn-md text-white" href="<?= base_url("mahasiswa/surat/tambah/" . encrypt_url($surat['id'])); ?>"><i class="fas fa-exclamation-triangle"></i> Ambil alih sekarang</a>

						</div>
					</div>
				</div>
			<?php }
		} */		
		?>

		<?php /*  if (($surat['id_status'] == 7) && ($this->session->userdata('role') == 2) &&  ($surat['id_kategori_surat'] != 6)) { ?>
			<div class="card shadow mt-3">
				<a href="#collStatus" class="d-block card-header pt-3 pb-2 bg-dark" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collStatus">
					<p class="h5 text-center font-weight-bold text-white"> ACC Kaprodi </p>
				</a>
				<div class="collapse show" id="collStatus">
					<div class="card-body pl-3">
						<p class="text-center">Perwakilan ACC Kaprodi oleh TU</p>
						<?php echo form_open('admin/surat/persetujuan_kaprodi'); ?>
						<input type="hidden" value="<?= $surat['user_id']; ?>" name="id_mhs">
						<input type="hidden" value="<?= $surat['id']; ?>" name="id_surat">
						<button type="submit" class="btn btn-danger form-control"><i class="fas fa-exclamation-triangle"></i> ACC Surat ini</button>
						<?php echo form_close(); ?>
					</div>
				</div>
			</div>
		<?php } */ ?>


		<?php /* if (($surat['id_status'] == 8) && ($this->session->userdata('role') == 1)) { ?>
			<div class="card shadow mt-3">
				<a href="#collStatus" class="d-block card-header pt-3 pb-2 bg-dark" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collStatus">
					<p class="h5 text-center font-weight-bold text-white"> ACC Direktur </p>
				</a>
				<div class="collapse show" id="collStatus">
					<div class="card-body pl-3">
						<p class="text-center">Perwakilan ACC Direktur oleh TU Pasca</p>
						<?php echo form_open('admin/surat/persetujuan_direktur'); ?>
						<input type="hidden" value="<?= $surat['user_id']; ?>" name="id_mhs">
						<input type="hidden" value="<?= $surat['id']; ?>" name="id_surat">
						<button type="submit" class="btn btn-danger form-control"><i class="fas fa-exclamation-triangle"></i> ACC Surat ini</button>
						<?php echo form_close(); ?>
					</div>
				</div>
			</div>
		<?php } */ ?>
	</div>
	<!-- /.col -->
</div>
<!-- /.row -->


<!-- Modal -->
<div class="modal fade" id="error_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Terjadi kesalahan</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>

			<div class="modal-body">
				<p><i class="fas fa-exclamation-triangle"> </i> Opsi ini hanya jika semua data yang dikirimkan sudah sesuai seluruhnya!</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
			</div>
		</div>
	</div>
</div>



<?php call_scripts(); ?>