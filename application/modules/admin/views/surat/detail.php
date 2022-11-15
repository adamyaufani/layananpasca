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

		<?php if (($surat['id_status'] == 8 || $surat['id_status'] == 9) && $surat['id'] < 785 ) {	?>
			<div class="alert alert-danger"><i class="fas fa-exclamation-triangle"></i> <strong>Mohon dicermati.</strong> Surat ini merupakan surat lama yang diajukan <strong>sebelum proses update sistem</strong> pada 11 November 2022. Jika PDF-nya ingin digenerate maka perlu melakukan proses di bawah. </div>
		<?php } ?>

		<!-- Surat diproses oleh Kaprodi -->
		<?php if (($surat['id_status'] == 3 || $surat['id_status'] == 7) && $this->session->userdata('role') == 6) { ?>

			<div class="card shadow mb-3">
				<a href="#collPengantar" class="d-block card-header pt-3 pb-2 bg-tosca" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collPengantar">
					<p class="h6 font-weight-bold text-white">Pengantar</p>
				</a>
				<div class="collapse show" id="collPengantar">
					<div class="card-body">
						<p class="font-italic">Assalamu'alaikum warahmatullahi wabarakatuh</p>
						<p> Kepada Yth. Kepala Program Studi <?= $surat['prodi']; ?>, mohon kesediaanya untuk memberikan persetujuan pada surat <strong><?= $surat['kategori_surat']; ?></strong> yang diajukan oleh <strong><?= $surat['fullname']; ?></strong>.</p>

						<p> Adapun kelengkapan administratif yang dibutuhkan sudah diverifikasi kebenarannya oleh staf Tata Usaha <?= $surat['prodi']; ?>.</p>

						<p>Atas perhatiannya kami ucapkan terima kasih.</p>
						<p class="font-italic">Wassalamu'alaikum warahmatullahi wabarakatuh</p>
					</div>
				</div>
			</div>
		<?php } ?>

		<!-- Surat diproses oleh Direktur -->
		<?php if (($surat['id_status'] == 9) && $this->session->userdata('role') == 5) { ?>

			<div class="card shadow mb-3">
				<a href="#collPengantar" class="d-block card-header pt-3 pb-2 bg-tosca" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collPengantar">
					<p class="h6 font-weight-bold text-white">Pengantar</p>
				</a>
				<div class="collapse show" id="collPengantar">
					<div class="card-body">
						<p class="font-italic">Assalamu'alaikum warahmatullahi wabarakatuh</p>
						<p>Kepada Yth. Direktur Program Pascasarjana UMY, mohon kesediaanya untuk memberikan persetujuan pada Surat <strong><?= $surat['kategori_surat']; ?></strong> yang diajukan oleh <strong><?= $surat['fullname']; ?> (<?= $surat['prodi']; ?>)</strong> </p>
						<p>Atas perhatiannya kami ucapkan terima kasih.</p>
						<p class="font-italic">Wassalamu'alaikum warahmatullahi wabarakatuh</p>
					</div>
				</div>
			</div>

		<?php } ?>

		<div class="card shadow">
			<a href="#collKeterangan" class="d-block card-header pt-3 pb-2 bg-abumuda " data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collKeterangan">
				<p class="h6 font-weight-bold text-white">Keterangan</p>
			</a>
			<div class="collapse show" id="collKeterangan">
				<div class="card-body">

					<?php
					if (
						($surat['id_status'] == 8 && $this->session->userdata('role') == 5) ||
						($surat['id_status'] == 7 && $this->session->userdata('role') == 6)
					) {
						echo form_open('admin/surat/disetujui');						
					}

					if ($surat['id_kategori_surat'] == 6 && $this->session->userdata('role') == 1) {
						echo form_open('admin/surat/acc_yudisium');
					} 

					if (($surat['id_status'] == 2 || $surat['id_status'] == 5) && $this->session->userdata('role') == 2) {
						echo form_open('admin/surat/verifikasi');
					}

					//form direktur pasca utk menerbitkan surat
					if (($surat['id_status'] == 9) && $this->session->userdata('role') == 5) {

						echo form_open('admin/surat/terbitkan_surat');
					}
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

					<?php if (($surat['id_status'] == 2 || $surat['id_status'] == 3 || $surat['id_status'] == 5 || $surat['id_status'] == 7 || $surat['id_status'] == 8  || $surat['id_status'] == 11 ) 
						&& ($this->session->userdata('role') == 2 || $this->session->userdata('role') == 1)) { 
					?>
						<div class="form-row pt-3">
							<div class="col-md-12">

							<?php if ($this->session->userdata('role') == 1 ) { 
								$admin = "Tata Usaha Pascasarjana";							
							
								if($surat['id_kategori_surat'] == '6') {
									form_verifikasi_admin($surat, $admin, $surat['id_kategori_surat']);
								}			
							} else  {
								$admin = "Tata Usaha Prodi " . $surat['prodi'];
			
								if( ($surat['id_kategori_surat'] !== '6') && ($surat['id_status'] !== '7') && ($surat['id_status'] !== '8') && ($surat['id_status'] !== '11') ) {
									form_verifikasi_admin($surat, $admin, $surat['id_kategori_surat']);
								}		
							}
							?>
						
							</div>
						</div>

						<script>
							$(function() {

								<?php if ($surat['id_status'] == 2) { ?>

									var check_all = sizeof = $("input[name='sizeof_ket_surat']").val();

									$('#diterima').click(function(e) {
										if ($('.verifikasi:checked').length != check_all) {

											$('#error_modal').modal("show");
											return false;
										}
									});

								<?php } ?>

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


					if ($surat['id_status'] == 4 && $this->session->userdata('role') == 2) { ?>
						<div class="form-row pt-3">
							<div class="col-md-12">
								<input type="submit" id="sub1" value="Menunggu perbaikan kelengkapan administrasi" name="submit" class="btn btn-perak btn-md btn-block" disabled>
							</div>
						</div>
					<?php }

					if ($surat['id_status'] == 7 && $this->session->userdata('role') == 6) { ?>
						<div class="form-row pt-3">
							<div class="col-md-12">
								<div class="card">
									<div class="card-header">
										Persetujuan Ketua Program Studi
									</div>
									<div class="card-body">

										<p> Saya selaku Ketua Program Studi <?= $surat['prodi']; ?> memberikan persetujuan pada <strong>Surat <?= $surat['kategori_surat']; ?></strong> yang diajukan oleh <strong><?= $surat['fullname']; ?></strong> </p>

										<p>Dengan demikian surat ini dapat diteruskan prosesnya ke tingkat fakultas.</p>

										<p class="mt-3">
											<span class="pl-2 mb-2 d-inline-block"><input type="checkbox" name="" id="sudahPeriksa"> Pernyataan ini dibuat dengan sebenar-benarnya dan dapat dipertanggung jawabkan kebenarannya. <a class="help" data-toggle="tooltip" data-placement="top" title="Centang untuk mengaktifkan tombol verifikasi."><i class="fa fa-info-circle"></i></a></span>
										</p>


										<input type="hidden" name="prodi" value="<?= $surat['id_prodi']; ?>" />
										<input type="submit" id="sub1" value="Beri Persetujuan" name="submit" class="btn btn-<?= $surat['badge']; ?> btn-md btn-block" disabled>
									</div>


								</div>

							</div>
						</div>

						<script>
							$(function() {
								$('#sudahPeriksa').click(function(e) {
									if ($(this).is(':checked')) {
										$('#sub1').removeAttr('disabled');
									} else {
										$('#sub1').attr('disabled', 'disabled');
									}
								});
							});
						</script>
					<?php }

					if ($surat['id_status'] == 9 && $this->session->userdata('role') == 5) { ?>
						<div class="form-row pt-3">
							<div class="col-md-12">

								<div class="card">
									<div class="card-header">
										Persetujuan Direktur Program Pascasarjana
									</div>
									<div class="card-body">

										<a href="<?= base_url('admin/surat/pratinjau_direktur/' . encrypt_url($surat['id'])); ?>" class="btn btn-md btn-perak mb-4" target="_blank"><i class="fas fa-eye"></i> Pratinjau Surat</a>

										<p> Saya selaku Direktur Program Pascasarjana UMY memberikan persetujuan pada <strong>Surat <?= $surat['kategori_surat']; ?></strong> yang diajukan oleh <strong><?= $surat['fullname']; ?></strong>.</p>

										<p>Dengan demikian surat ini dapat diterbitkan.</p>

										<p class="mt-3">
											<span class="pl-2 mb-2 d-inline-block"><input type="checkbox" name="" id="sudahPeriksa"> Pernyataan ini dibuat dengan sebenar-benarnya dan dapat dipertanggung jawabkan kebenarannya. <a class="help" data-toggle="tooltip" data-placement="top" title="Centang untuk mengaktifkan tombol verifikasi."><i class="fa fa-info-circle"></i></a></span>
										</p>


										<input type="submit" id="sub1" value="Beri Persetujuan" name="submit" class="btn btn-<?= $surat['badge']; ?> btn-md btn-block" disabled>

									</div>
								</div>
							</div>
						</div>
						<script>
							$(function() {
								$('#sudahPeriksa').click(function(e) {
									if ($(this).is(':checked')) {
										$('#sub1').removeAttr('disabled');
									} else {
										$('#sub1').attr('disabled', 'disabled');
									}
								});
							});
						</script>

					<?php }
					form_close(); ?>
				</div>
			</div>
		</div>

		<!-- Proses setting surat -->
		<?php if 
				( 
					(
						(
							($surat['id_status'] == 8 || $surat['id_status'] == 9) 
							&& $surat['id'] < 785 
						) 
						|| ($surat['id_status'] == 8 && $surat['id'] > 785 )
					)
				 && $this->session->userdata('role') == 1 
				 
				 ) {	?>
			<div class="card shadow mt-3">
				<a href="#collterbit" class="d-block card-header pt-3 pb-2 bg-success" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collterbit">
					<p class="h6 font-weight-bold text-white">Proses Surat</p>
				</a>
				<div class="collapse show" id="collterbit">
					<div class="card-body pb-3">

						<p>Lakukan pengaturan di bawah ini sebelum surat diperiksa oleh Direktur Pascasarjana.</p>
						<?php echo form_open('admin/surat/pratinjau'); ?>

						<div class="form-group row">
							<label class="col-md-4" for="">Stempel Basah
								<small class="form-text text-muted">Berdasarkan permintaan. Memerlukan komunikasi lebih lanjut dengan admin Pasca.</small></label>
							<div class="col-md-8">

								<?php


								if ((validation_errors())) {
									$set_stempel = set_checkbox('stempel_basah');
								} else {
									if ($no_surat_data['stempel_basah'] == NULL) {
										if (get_meta_value('hal', $surat['id'], false)) {
											$value_kepada = get_meta_value('tujuan_surat', $surat['id'], false);
										} else {
											$value_kepada = $surat['kategori_surat'];
										}
									}
								}
								?>

								<input type="checkbox" name="stempel_basah" id="" <?= (validation_errors()) ? set_checkbox('stempel_basah') : (($no_surat_data['stempel_basah'] == 'on') ? 'checked' : ''); ?>> Centang untuk stempel basah.
								<span class="text-danger"><?php echo form_error('stempel_basah'); ?></span>
							</div>
						</div>

						<div class="form-group row">
							<label class="col-md-4" for="">Nomor Surat
								<small class="form-text text-muted">+1 dari nomor sebelumnya dengan kategori yang sama</small>
							</label>
							<div class="col-md-8">

								<?php
								$no_surat = $this->db->query("select max(no_surat) as last_no from no_surat where id_kategori_surat= " . $surat['id_kategori_surat'] . " AND YEAR(tanggal_terbit) =" . date('Y'))->row_array();

								if ($no_surat['last_no'] > 0) {
									$last_no = $no_surat['last_no'] + 1;
								} else {
									$last_no = 1;
								}
								?>
								<input type="hidden" name="user_id" value="<?= $surat['user_id']; ?>">
								<input type="hidden" name="id_prodi" value="<?= $surat['id_prodi']; ?>" />
								<input type="hidden" name="id_surat" id="" value="<?= $surat['id']; ?>">
								<input type="hidden" name="id_kategori_surat" id="" value="<?= $surat['id_kategori_surat'] ?>">

								<input type="number" name="no_surat" id="" value="<?= (validation_errors()) ? set_value('no_surat') : (($no_surat_data['no_surat']) ? $no_surat_data['no_surat'] : $last_no); ?>" class="form-control <?= (form_error('no_surat')) ? 'is-invalid' : ''; ?> ">
								<span class="text-danger"><?php echo form_error('no_surat'); ?></span>
							</div>
						</div>


						<div class="form-group row">
							<label class="col-md-4" for="">Kategori Tujuan Surat</label>
							<div class="col-md-8">

								<?php $kat_tujuan_surat = $this->db->query("select * from kat_tujuan_surat")->result_array(); ?>

								<select name="kat_tujuan_surat" id="kat_tujuan_surat" class="form-control <?= (form_error('kat_tujuan_surat')) ? 'is-invalid' : ''; ?> ">

									<option value="">Pilih Kategori Tujuan Surat</option>
									<?php foreach ($kat_tujuan_surat as $kat_tujuan_surat) { ?>
										<option value="<?= $kat_tujuan_surat['id']; ?>" <?= (validation_errors()) ? set_select('kat_tujuan_surat', $kat_tujuan_surat['id']) : (($no_surat_data['kat_tujuan_surat'] == $kat_tujuan_surat['id']) ? "selected" : '');
																																		?>>
											<?= $kat_tujuan_surat['kat_tujuan_surat']; ?></option>
									<?php }

									?>

								</select>

								<span class="text-danger"><?php echo form_error('kat_tujuan_surat'); ?></span>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-md-4" for="">Tujuan Surat</label>
							<div class="col-md-8">
								<input type="hidden" value="<?= $selected = (validation_errors()) ? set_value('tujuan_surat') : $no_surat_data['tujuan_surat']; ?>" name="selected" />

								<select name="tujuan_surat" id="tujuan_surat" class="form-control <?= (form_error('tujuan_surat')) ? 'is-invalid' : ''; ?> ">
								</select>
								<span class="text-danger"><?php echo form_error('tujuan_surat'); ?></span>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-md-4" for="">Urusan Surat</label>
							<div class="col-md-8">

								<?php $urusan_surat = $this->db->query("select * from urusan_surat")->result_array(); ?>

								<select name="urusan_surat" id="" class="form-control <?= (form_error('urusan_surat')) ? 'is-invalid' : ''; ?> ">
									<option value="">Urusan Surat</option>
									<?php foreach ($urusan_surat as $urusan) { ?>
										<option value="<?= $urusan['id']; ?>" <?= (validation_errors()) ? set_select('urusan_surat', $urusan['id']) : (($no_surat_data['urusan_surat'] == $urusan['id']) ? "selected" : '');
																													?>>
											<?= $urusan['urusan']; ?></option>
									<?php } ?>
								</select>
								<span class="text-danger"><?php echo form_error('urusan_surat'); ?></span>
							</div>
						</div>

						<div class="form-group row">
							<label class="col-md-4" for="">Lampiran
								<small class="form-text text-muted">Kosongkan jika tidak ada lampiran.</small></label>
							<div class="col-md-8">

								<input type="number" min="0" max="20" step="1" name="lamp" id="lamp" class="form-control" value="<?= (validation_errors()) ? set_value('lamp') : (($no_surat_data['lamp']) ? $no_surat_data['lamp'] : '');  ?>">
								<span class="text-danger"><?php echo form_error('lamp'); ?></span>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-md-4" for="">Template surat
								<small class="form-text text-muted">Template surat yang dipakai untuk surat ini.</small></label>
							<div class="col-md-8">

								<select name="template_surat" id="" class="form-control <?= (form_error('template_surat')) ? 'is-invalid' : ''; ?> ">
									<option value="">template Surat</option>
									<?php foreach ($template as $template) { ?>
										<option value="<?= $template['id']; ?>" <?= (validation_errors()) ? set_select('template_surat', $template['id']) : (($no_surat_data['template_surat'] == $template['id']) ? "selected" : '');
																														?>>
											<?= $template['nama_template']; ?></option>
									<?php } ?>
								</select>
								<span class="text-danger"><?php echo form_error('lamp'); ?></span>
							</div>
						</div>

						<div class="form-group row">
							<label class="col-md-4" for="">Hal
								<small class="form-text text-muted">Hal bisa disesuaikan.</small></label>
							<div class="col-md-8">

								<?php

								if ((validation_errors())) {
									$value_hal = set_value('hal');
								} else {
									if ($no_surat_data['hal'] == NULL) {
										if (get_meta_value('hal', $surat['id'], false)) {
											$value_hal = get_meta_value('hal', $surat['id'], false);
										} else {
											$value_hal = $surat['kategori_surat'];
										}
									} else {
										$value_hal = $no_surat_data['hal'];
									}
								}
								?>

								<input type="text" name="hal" id="hal" class="form-control" value="<?= $value_hal; ?>">
								<span class="text-danger"><?php echo form_error('hal'); ?></span>
							</div>
						</div>

						<div class="form-group row">
							<label class="col-md-4" for="">Kepada
								<small class="form-text text-muted">Surat ini ditujukan kepada. Tujuan surat bisa diganti jika diperlukan.</small>
							</label>

							<?php

							if ((validation_errors())) {
								$value_kepada = set_value('instansi');
							} else {
								if ($no_surat_data['instansi'] == NULL) {

									if (get_meta_value('tujuan_surat', $surat['id'], false)) {

										$value_kepada = get_meta_value('tujuan_surat', $surat['id'], false);
									} else {

										$value_kepada = $surat['tujuan_surat'];
									}
								} else {

									$value_kepada = $no_surat_data['instansi'];
								}
							}
							?>

							<div class="col-md-8">
								<textarea name="instansi" id="" cols="30" rows="2" class="textarea-summernote <?= (form_error('instansi')) ? 'is-invalid' : ''; ?> "><?= $value_kepada; ?></textarea>
								<span class="text-danger"><?php echo form_error('instansi'); ?></span>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-md-4" for="">Tembusan
								<small class="form-text text-muted">Tembusan bisa disesuaikan. Pisahkan dengan koma jika lebih dari satu.</small>
							</label>
							<div class="col-md-8">

								<?php

								if ((validation_errors())) {
									$value_tembusan = set_value('tembusan');
								} else {
									if ($no_surat_data['tembusan'] == NULL) {
										// if (get_meta_value('tembusan', $surat['id'], false) !== '-') {
										// 	$value_tembusan = get_meta_value('tembusan', $surat['id'], false);
										// } else {
										$value_tembusan = "";
										// }
									} else {
										$value_tembusan = $no_surat_data['tembusan'];
									}
								}
								?>

								<input type="text" name="tembusan" class="form-control mb-2" value="<?= $value_tembusan; ?>" placeholder="Contoh: Rektor, Ka Prodi" />
								<span class="text-danger"><?php echo form_error('tembusan'); ?></span>
							</div>
						</div>

						<input type="submit" id="sub1" value="Pratinjau Surat" name="submit" class="btn btn-<?= $surat['badge']; ?> btn-md btn-block">
						<?php form_close(); ?>
					</div>
				</div>
			</div>
		<?php } ?>

		<!-- jika surat sudah diterbitkan -->
		<?php if ($surat['id_status'] == 10 || ($surat['id'] < 785 && $surat['id_status'] == 9)) { ?>
			<div class="card shadow mt-3">
				<a href="#collterbit" class="d-block card-header pt-3 pb-2 bg-success" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collterbit">
					<p class="h6 font-weight-bold text-white">Surat</p>
				</a>
				<div class="collapse show" id="collterbit">
					<div class="card-body pb-3">
						Download Surat
						<?php if ($surat['id'] < 785 && !$template) { ?> 
							<a href="<?= base_url('/admin/surat/cetak_surat/' .  encrypt_url($surat['id'])); ?>/header" class="btn btn-success"> <i class="fas fa-file-pdf"></i> PDF</a>
						<?php } elseif($surat['id'] < 785)  {  ?>
							<a href="<?= base_url('/admin/surat/cetak_surat_lama/' .  encrypt_url($surat['id'])); ?>/header" class="btn btn-success"> <i class="fas fa-file-pdf"></i> PDF</a>
						<?php } else { ?>
							<a href="<?= base_url('/admin/surat/cetak_surat/' .  encrypt_url($surat['id'])); ?>/header" class="btn btn-success"> <i class="fas fa-file-pdf"></i> PDF</a>

							<?php if ($this->session->userdata('role') == 1) { ?>
								<a href="<?= base_url('/admin/surat/cetak_surat/' .  encrypt_url($surat['id'])); ?>/noheader" class="btn btn-success"> <i class="fas fa-file-pdf"></i> PDF tanpa Header dan Footer</a>
							<?php } ?>

						<?php } ?>

					</div>
				</div>
			</div>
		<?php

		}


		?>



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

<script>
	$(document).ready(function() {
		$('#kat_tujuan_surat').change(function() {
			var id = $(this).val();
			$.ajax({
				url: '<?= base_url('admin/surat/get_tujuan_surat'); ?>',
				method: 'POST',
				data: {
					kat_tujuan_surat: id
				},
				dataType: 'json',
				success: function(data) {
					console.log(data)
					var html = '';
					var sel = $('input[name=selected]').val();

					var i;
					if (data.length == 0) {
						html += '<option>Tujuan tidak ditemukan</option>'
					} else {
						for (i = 0; i < data.length; i++) {

							html += '<option value="' + data[i].id + '"' + (data[i].id === sel ? 'selected="selected"' : '') + '>' + data[i].tujuan_surat + '</option>';

						}
					}

					$('#tujuan_surat').html(html);

				}
			});
		});

		$('#kat_tujuan_surat').trigger("change");

	});
</script>

<?php call_scripts(); ?>