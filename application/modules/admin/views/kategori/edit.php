<div class="row">
	<div class="col-md-12">
		<link rel="stylesheet" href="<?= base_url('public/vendor/jquery-ui-1.12.1/jquery-ui.min.css'); ?>">
		<!-- fash message yang muncul ketika proses penghapusan data berhasil dilakukan -->



	</div>



	<div class="col-md-12">
		<div id="success-alert" class="alert alert-success simpan"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true"> × </button>
			<h4> Sukses! </h4>Data berhasil diubah
		</div>

		<div id="error-alert" class="alert alert-danger simpan"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true"> × </button>
			<h4> Ada Kesalahan! </h4>Periksa kembali formulir Anda!
		</div>


		<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

		<style>
			.alert.simpan {
				display: none;
			}

			#sortable1 {
				width: 100%;
			}

			#sortable2 {
				width: 100%;
			}

			#sortable1,
			#sortable2 {

				min-height: 20px;
				list-style-type: none;
				margin: 0;
				padding: 5px 0 0 0;
				float: left;
				margin-right: 10px;
			}

			#sortable1 li,
			#sortable2 li {
				margin: 0 5px 5px 5px;
				padding: 5px;
				font-size: 14px;
				cursor: move;
			}

			.error {
				color: red;
			}
		</style>

		<div class="card card-success card-outline">
			<div class="card-header">
				Kategori Surat
			</div>
			<div class="card-body box-profile">

				<?php echo form_open('', array('id' => 'edit_kategori_surat', 'class' => 'form-horizontal'));  ?>
				<div class="form-group row">
					<label for="kategori_surat" class="col-md-2 control-label">Kategori Surat *</label>
					<div class="col-md-10">
						<input type="text" value="<?= (validation_errors()) ? set_value('kategori_surat') : $kat['kategori_surat'];  ?>" name="kategori_surat" class="form-control <?= (form_error('kategori_surat')) ? 'is-invalid' : ''; ?>" id="kategori_surat">
						<input type="hidden" name="id" value="<?= $kat['id']; ?>">
						<span class="invalid-feedback"><?php echo form_error('kategori_surat'); ?></span>
					</div>
				</div>


				<div class="form-group row">
					<label for="kode" class="col-md-2 control-label">Kode</label>
					<div class="col-md-10">
						<input type="text" value="<?= (validation_errors()) ? set_value('kode') : $kat['kode'];  ?>" name="kode" class="form-control <?= (form_error('kode')) ? 'is-invalid' : ''; ?>" id="kode">

						<span class="invalid-feedback"><?php echo form_error('kode'); ?></span>
					</div>
				</div>

				<div class="form-group row">
					<label for="kode" class="col-md-2 control-label">Pengguna</label>
					<div class="col-md-10">
						<select name="klien" class="form-control">
							<option value="" <?php echo  set_select('klien', '', TRUE); ?>>Pilih Pengguna</option>
							<option value="m" <?= (validation_errors()) ? set_select('klien', 'm') : "";
																echo ($kat['klien'] == 'm') ? "selected" : ""; ?>>
								Mahasiswa</option>
							<option value="d" <?= (validation_errors()) ? set_select('klien', 'd') : "";
																echo ($kat['klien'] == 'd') ? "selected" : ""; ?>>
								Dosen</option>
							<option value="p" <?= (validation_errors()) ? set_select('klien', 'p') : "";
																echo ($kat['klien'] == 'p') ? "selected" : ""; ?>>
								Pascasarjana</option>
							<option value="j" <?= (validation_errors()) ? set_select('klien', 'i') : "";
																echo ($kat['klien'] == 'i') ? "selected" : ""; ?>>
								Program Studi</option>
						</select>
						<span class="text-danger" style="font-size: 80%;"><?php echo form_error('klien'); ?></span>
					</div>
				</div>

				<div class="form-group row">
					<label for="pilih_prodi" class="col-md-2 control-label">Pilih Prodi</label>
					<div class="col-md-10">

						<select name="pilih_prodi[]" class="form-control pilih_prodi">
							<?php
							if ($kat['prodi'] > 0) {
								foreach (explode(',', $kat['prodi']) as $list_prodi) {  ?>
									<option value="<?= $list_prodi; ?>"><?= getProdibyId($list_prodi)['prodi']; ?></option>
							<?php }
							}
							?>
						</select>


						<span class="text-danger" style="font-size: 80%;"><?php echo form_error('klien'); ?></span>
					</div>
				</div>

				<div class="form-group row">
					<label for="deskripsi" class="col-md-2 control-label">Deskripsi</label>
					<div class="col-md-10">

						<div class="<?= (form_error('deskripsinya')) ? 'summernote-is-invalid' : ''; ?>"><textarea name="deskripsinya" class="textarea-summernote"><?= (validation_errors()) ? set_value('deskripsinya') : $kat['deskripsi'];  ?></textarea>
						</div>

						<span class="text-danger" style="font-size: 80%;"><?php echo form_error('deskripsinya'); ?></span>
					</div>
				</div>

				<div class="form-group row">
					<label for="tujuan_surat" class="col-md-2 control-label">Tujuan Surat</label>
					<div class="col-md-10">

						<div class="<?= (form_error('tujuan_surat')) ? 'summernote-is-invalid' : ''; ?>"><textarea name="tujuan_surat" class="textarea-summernote"><?= (validation_errors()) ? set_value('tujuan_surat') : $kat['tujuan_surat'];  ?></textarea>
						</div>

						<span class="text-danger" style="font-size: 80%;"><?php echo form_error('tujuan_surat'); ?></span>
					</div>
				</div>
				<!-- <div class="form-group row">
					<label for="tembusan" class="col-md-2 control-label">Tembusan</label>
					<div class="col-md-10">

						<div class="<?= (form_error('tembusan')) ? 'summernote-is-invalid' : ''; ?>"><textarea name="tembusan" class="textarea-summernote"><?= (validation_errors()) ? set_value('tembusan') : $kat['tembusan'];  ?></textarea>
						</div>

						<span class="text-danger" style="font-size: 80%;"><?php echo form_error('tembusan'); ?></span>
					</div>
				</div> -->


				<div class="form-group row">
					<label for="template" class="col-md-2 control-label">Form Field
						<small id="" class="form-text text-muted">Seret lalu lepaskan form field yang tidak aktif ke kolom form field aktif.</small>
					</label>
					<div class="col-md-5">
						<div class="card card-success card-outline">
							<div class="card-header">Field terpakai </div>
							<div class="card-body box-profile ">

								<div id="sortable2" class="connectedSortable errorTxt">
									<?php
									$this->db->select('*');
									$this->db->from('kat_keterangan_surat');
									$this->db->where(['id_kategori_surat' => $kat['id'], 'aktif' => 1]);
									$this->db->order_by('urutan', 'ASC');
									$field =	$this->db->get()->result_array();

									$last = end($field);
									$select = array();

									if ($field) {
										foreach ($field as $k => $field) {
											$select[] =  'sort=' . $field['id'];
									?>

											<div class="ui-state-highlights" id="item-<?= $field['id']; ?>">

												<p class="nama_field"><span class="nama_field_disini"><?= $field['kat_keterangan_surat']; ?></span></p>
												<div>

													<div class="mb-3">
														<input type="checkbox" <?= ($field['required'] == 1) ? 'checked="checked"' : ''; ?> name="required" value="1" />
														<label for="exampleFormControlInput1" class="form-label">Centang jika field wajib</label>
													</div>
													<div class="mb-3">
														<label for="exampleFormControlInput1" class="form-label">Nama Field</label>
														<input class="form-control" type="text" value="<?= $field['kat_keterangan_surat']; ?>" name="kat_keterangan_surat" />
													</div>
													<div class="mb-3">
														<label for="exampleFormControlInput1" class="form-label">Placeholder</label>
														<input class="form-control" type="text" value="<?= $field['placeholder']; ?>" name="placeholder" />
													</div>
													<div class="mb-3">
														<label for="exampleFormControlInput1" class="form-label">Key (wajib, tanpa spasi, huruf kecil semua. Hindari kata-kata berikut : nama, nim, prodi, nomor_surat, tanggal, lampiran, hal, kepada, qrcode, direktur)</label>
														<input class="form-control" type="text" value="<?= $field['key']; ?>" name="key" placeholder="Key sebagai kode identitas field" />
													</div>
													<div class="mb-3">
														<label for="exampleFormControlInput1" class="form-label">Deskripsi</label>
														<textarea class="form-control" name="deskripsi" placeholder="Deskripsi singkat penjelasan field" /><?= $field['deskripsi']; ?></textarea>
													</div>
													<div class="mb-3">
														<label for="exampleFormControlInput1" class="form-label">Jenis Field</label>
														<select class="form-control" name="type">
															<option>Pilih jenis field</option>
															<option value='text' <?= ($field['type'] == 'text') ? 'selected="selected"' : ''; ?>>Teks singkat</option>
															<option value='number' <?= ($field['type'] == 'number') ? 'selected="selected"' : ''; ?>>Angka</option>
															<option value='textarea' <?= ($field['type'] == 'textarea') ? 'selected="selected"' : ''; ?>>Teks panjang</option>
															<option value='wysiwyg' <?= ($field['type'] == 'wysiwyg') ? 'selected="selected"' : ''; ?>>Teks editor</option>
															<option value='select_dosen' <?= ($field['type'] == 'select_dosen') ? 'selected="selected"' : ''; ?>>Pilih Dosen</option>
															<option value='select_mahasiswa' <?= ($field['type'] == 'select_mahasiswa') ? 'selected="selected"' : ''; ?>>Pilih Mahasiswa</option>
															<option value='sem' <?= ($field['type'] == 'sem') ? 'selected="selected"' : ''; ?>>Semester</option>
															<option value='ta' <?= ($field['type'] == 'ta') ? 'selected="selected"' : ''; ?>>Tahun Akademik</option>
															<option value='date' <?= ($field['type'] == 'date') ? 'selected="selected"' : ''; ?>>Tanggal</option>
															<option value='url' <?= ($field['type'] == 'url') ? 'selected="selected"' : ''; ?>>Url</option>
															<option value='file' <?= ($field['type'] == 'file') ? 'selected="selected"' : ''; ?>>File/Image</option>
														</select>
													</div>
													<div class="mb-3">
														<a class="form-control btn btn-warning simpan" data-id="<?= $field['id']; ?>" style="cursor:pointer">Simpan</a>
													</div>
												</div>
											</div>
									<?php
										} // endforeach 

										$imp = implode("&", $select);
									} else {
										echo "<span class='ml-2 mb-1 belum-ada-field'>Belum ada field.</span>";
									}
									?>
									<span id="errNm2"></span>
								</div>

								<input type="hidden" name="field_surat" data-error="#errNm2" class="field_surat" id="" value="<?= ($field) ? $imp : ''; ?>">

							</div>
						</div>
					</div>

					<div class="col-md-5">
						<div class="card card-success card-outline">
							<div class="card-header">Field tidak terpakai <a class="float-right tambah-field btn btn-sm btn-warning" data-id="<?= $kat['id']; ?>" style="cursor:pointer;"><i class="fas fa-plus"></i> Tambah form field</a></div>
							<div class="card-body box-profile">



								<div id="sortable1" style="list-style: none;" class="connectedSortable keterangan_surat list-group pl-0">



									<?php
									if ($keterangan_surat) {

										foreach ($keterangan_surat as $field) {
									?>

											<div class="ui-state-highlights" id="item-<?= $field['id']; ?>">

												<p class="nama_field"><span class="nama_field_disini"><?= $field['kat_keterangan_surat']; ?></span></p>
												<div>
													<div class="mb-3">
														<input type="checkbox" <?= ($field['required'] == 1) ? 'checked="checked"' : ''; ?> name="required" value="1" />
														<label for="exampleFormControlInput1" class="form-label">Centang jika field wajib</label>
													</div>
													<div class="mb-3">
														<label for="exampleFormControlInput1" class="form-label">Nama Field</label>
														<input class="form-control field-kat_keterangan_surat" type="text" value="<?= $field['kat_keterangan_surat']; ?>" name="kat_keterangan_surat" />
													</div>
													<div class="mb-3">
														<label for="exampleFormControlInput1" class="form-label">Placeholder</label>
														<input class="form-control field-placeholder" type="text" value="<?= $field['placeholder']; ?>" name="placeholder" />
													</div>
													<div class="mb-3">
														<label for="exampleFormControlInput1" class="form-label">Key (wajib, tanpa spasi, huruf kecil semua. Hindari kata-kata berikut : nama, nim, prodi, nomor_surat, tanggal, lampiran, hal, kepada, qrcode, direktur)</label>
														<input class="form-control field-key" type="text" value="<?= $field['key']; ?>" name="key" placeholder="Key sebagai kode identitas field" />
													</div>
													<div class="mb-3">
														<label for="exampleFormControlInput1" class="form-label">Deskripsi</label>
														<textarea class="form-control" name="deskripsi" placeholder="Deskripsi singkat penjelasan field" /><?= $field['deskripsi']; ?></textarea>
													</div>
													<div class="mb-3">
														<label for="exampleFormControlInput1" class="form-label">Jenis Field</label>
														<select class="form-control field-type" name="type">
															<option value=''>Pilih jenis field</option>
															<option value='text' <?= ($field['type'] == 'text') ? 'selected="selected"' : ''; ?>>Teks singkat</option>
															<option value='number' <?= ($field['type'] == 'number') ? 'selected="selected"' : ''; ?>>Angka</option>
															<option value='textarea' <?= ($field['type'] == 'textarea') ? 'selected="selected"' : ''; ?>>Teks panjang</option>
															<option value='wysiwyg' <?= ($field['type'] == 'wysiwyg') ? 'selected="selected"' : ''; ?>>Teks editor</option>
															<option value='select_dosen' <?= ($field['type'] == 'select_dosen') ? 'selected="selected"' : ''; ?>>Pilih Dosen</option>
															<option value='select_mahasiswa' <?= ($field['type'] == 'select_mahasiswa') ? 'selected="selected"' : ''; ?>>Pilih Mahasiswa</option>
															<option value='sem' <?= ($field['type'] == 'sem') ? 'selected="selected"' : ''; ?>>Semester</option>
															<option value='ta' <?= ($field['type'] == 'ta') ? 'selected="selected"' : ''; ?>>Tahun Akademik</option>
															<option value='date' <?= ($field['type'] == 'date') ? 'selected="selected"' : ''; ?>>Tanggal</option>
															<option value='url' <?= ($field['type'] == 'url') ? 'selected="selected"' : ''; ?>>Url</option>
															<option value='file' <?= ($field['type'] == 'file') ? 'selected="selected"' : ''; ?>>File/Image</option>
														</select>
													</div>
													<div class="mb-3">
														<a class="form-control btn btn-warning simpan simpan-<?= $field['id']; ?>" data-id="<?= $field['id']; ?>" style="cursor:pointer">
															<span class="loading d-none">
																<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
																<span class="sr-only">Loading...</span>
															</span>
															Simpan
														</a>
													</div>

												</div>
											</div>


									<?php
										} // endforeach 
									}
									?>
								</div>
							</div>
						</div>

						<span class="text-danger" style="line-height:1.5rem;font-size: 80%;"><?php echo form_error('kat_keterangan_surat[]'); ?></span>

					</div>
				</div>

				<div class="form-group row">
					<label for="kode" class="col-md-2 control-label"></label>
					<div class="col-md-10">
						<input type="submit" name="submit" value="Edit Kategori Surat" class="btn btn-success btn-block">
					</div>
				</div>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>

	<div class="col-md-12 mt-4">

		<div class="card card-success card-outline">

			<div class="card-header">
				Template Surat
				<?php echo form_open(base_url('admin/templatesurat/tambah/t'), array('id' => 'tambah_kategori_surat', 'class' => 'form-horizontal  float-right'));  ?>
				<input type="hidden" value="<?= $kat['id']; ?>" name="id_kategori_surat">
				<button class="btn btn-sm btn-warning" name="submit" value="submit"><i class="fas fa-edit"></i> Tambah template</button>
				<?php echo form_close(); ?>
			</div>
			<div class="card-body">
				<table class="table table-bordered table-striped">
					<thead>
						<tr>
							<th width="92%">Nama Template</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($template as $template) { ?>
							<tr>
								<td><?= ($template["nama_template"]) ? $template["nama_template"] : "Template " . $template["id"]; ?></td>
								<td class="text-center"><a href="<?= base_url('admin/templatesurat/edit/' . $template["id"]); ?>" class="btn btn-success btn-sm"><i class="fas fa-edit"></i> Edit</a></td>
							</tr>
						<?php } ?>
					</tbody>
				</table>


			</div>
		</div>
	</div>
</div>

<script src="<?= base_url('public/vendor/jquery-ui-1.12.1/jquery-ui.min.js'); ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.js"></script>

<script type="text/javascript">
	$(document).ready(function() {

		$('.tambah-field').on('click', function() {
			var id = $(this).data('id');

			$.ajax({
				url: SITEURL + "admin/kategorisurat/tambah_field/" + id,
				success: function(res) {
					console.log(res);
					location.reload();
				},
				error: function(data) {
					console.log('Error:', data);
				}
			});
		});

	});


	var SITEURL = '<?php echo base_url(); ?>';

	$(function() {


		$("#sortable1, #sortable2")
			.accordion({
				collapsible: true,
				header: "> div > p",
				active: false
			})
			.sortable({
				connectWith: ".connectedSortable"
			}).disableSelection();
	});

	$("#sortable2")

		.sortable({
			placeholder: "ui-state-active",
			update: function(event, ui) {
				var sorted = $("#sortable2").sortable("serialize", {
					key: "sort"
				});
				// console.log(sorted);
				$('.field_surat').val(sorted);
				$("#sortable2").css('border-color', '#eeeeee');
				$("#errNm2").html('');
			},
		});


	// script untuk  menyimpan data field

	$('.simpan').on('click', function() {

		var id = $(this).data('id');
		//aktifkan preloader setelah button diklik
		$('.simpan-' + id).children('.loading').removeClass('d-none');

		var req = $('#item-' + id + ' div').children('input[name=required]').val(),
			kks = $('#item-' + id + ' div').children('input[name=kat_keterangan_surat]').val(),
			placeholder = $('#item-' + id + ' div').children('input[name=placeholder]').val(),
			deskripsi = $('#item-' + id + ' div').children('textarea[name=deskripsi]').val(),
			key = $('#item-' + id + ' div').children('input[name=key]').val(),
			type = $('#item-' + id + ' div').children('select[name=type]').val();

		$.ajax({
			url: SITEURL + "admin/kategorisurat/edit_field/" + id,
			data: {
				required: req,
				kat_keterangan_surat: kks,
				placeholder: placeholder,
				deskripsi: deskripsi,
				key: key,
				type: type
			},
			type: "post",
			dataType: 'json',
			success: function(res) {
				if (res.status == 'Error') {
					// foreach error keynya
					Object.keys(res.error).forEach(function(k) {
						if (res.error[k] !== '') {
							$('#item-' + id + ' div').find(".field-" + k).next('.invalid-feedback').hide();
							$('#item-' + id + ' div').find(".field-" + k).addClass('is-invalid');
							$('#item-' + id + ' div').find(".field-" + k).after('<div class="invalid-feedback">' + res.error[k] + '</div>');

						} else {

							$('#item-' + id + ' div').find(".field-" + k).next('.invalid-feedback').hide();
							$('#item-' + id + ' div').find(".field-" + k).removeClass('is-invalid');

						}
					});

				} else {
					$('#item-' + id + ' div').find('.invalid-feedback').hide();
					$('#item-' + id + ' div').find("input, select").removeClass('is-invalid');
				}

				//sembunyikan preloader
				$('.simpan-' + id).children('.loading').addClass('d-none').delay(3000);
				$('#item-' + id + ' p.nama_field').children('.nama_field_disini').html(res.data)

			},
			error: function(data) {
				console.log('Error:', data);
			}
		});

	});

	$("#edit_kategori_surat").validate({
		ignore: ":hidden:not(.field_surat)",
		errorClass: "is-invalid",
		rules: {
			kategori_surat: {
				required: true,
			},
			kode: {
				required: true,
			},

			klien: {
				required: true,
			},
			template: {
				required: true,
			},
			field_surat: {
				required: true,
				minlength: 6,
			},
		},
		messages: {
			kategori_surat: {
				required: "Kategori surat wajib diisi",
			},
			kode: {
				required: "Kode surat wajib diisi",
			},
			tujuan_surat: {
				required: "Tujuan surat wajib diisi",
			},
			klien: {
				required: "Pengguna surat wajib diisi",
			},
			template: {
				required: "Template surat wajib diisi",
			},
			field_surat: {
				required: "Field wajib diisi",
				minlength: "Field wajib diisi",
			},

		},
		errorPlacement: function(error, element) {
			error.addClass("invalid-feedback");
			var placement = $(element).data('error');
			if (placement) {
				$(placement).append(error);
				$(placement).parent().css("border", "1px solid #b0272b");
				$(placement).parent().css("border-radius", "4px");
				//scroll to top
				$('html, body').animate({
					scrollTop: 0
				}, 1000);
				console.log('errroor');
			} else {
				error.insertAfter(element);
			}

			//show error
			$("#error-alert").fadeTo(2000, 500).slideUp(500, function() {
				$("#error-alert").slideUp(500);
			});


		},
		submitHandler: function(form) {
			if ($("#edit_kategori_surat").valid()) {
				$.ajax({
					url: SITEURL + "admin/kategorisurat/edit_kategori_surat/",
					data: $('#edit_kategori_surat').serialize(),
					type: "post",
					dataType: 'json',
					success: function(res) {
						console.log(res);
						$("#success-alert").fadeTo(2000, 500).slideUp(500, function() {
							$("#success-alert").slideUp(500);
						});

						$('html, body').animate({
							scrollTop: 0
						}, 1000);
					},
					error: function(data) {
						console.log('Error:', data);
					}
				});
			} else {
				return false;
			}
		}
	});
</script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>
	$(document).ready(function() {
		$('.pilih_prodi').select2({
			ajax: {
				url: '<?= base_url('admin/kategorisurat/get_prodi'); ?>',
				dataType: 'json',
				type: 'post',
				delay: 250,
				data: function(params) {
					return {
						search: params.term,
					}
				},
				processResults: function(data) {
					return {
						results: data
					};
				},

				cache: true
			},
			placeholder: 'Pilih Prodi',
			minimumInputLength: 3,
			multiple: true,
		}).val([<?php
						if ($kat['prodi'] > 0) {
							foreach (explode(',', $kat['prodi']) as $list_prodi) {
								echo "'$list_prodi',";
							}
						}
						?>]).trigger('change');

	});
</script>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>