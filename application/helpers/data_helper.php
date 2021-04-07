<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


// print_r tool

function printrs($var)
{
	echo "<pre>";
	print_r($var);
	echo "</pre>";
}

function profPic($id, $w)
{
	if ($id) {
		$year = substr($id, 0, 4);
		$pic = '<div style="width:' . $w . 'px;height:' . $w . 'px; background:url(https://krs.umy.ac.id/FotoMhs/' . $year . '/' . $id . '.jpg) center top no-repeat; background-size:100%;" class="img-profile rounded-circle"></div>';
	} else {
		$pic = '<div style="width:' . $w . 'px;height:' . $w . 'px; background:url(https://source.unsplash.com/QAB-WJcbgJk/60x60) center top no-repeat; background-size:100%;" class="img-profile rounded-circle"></div>';
	}

	return $pic;
}


function bulan_romawi($bulan)
{
	$bln = array(
		1 =>   'I',
		'II',
		'III',
		'IV',
		'V',
		'VI',
		'VII',
		'VIII',
		'IX',
		'X',
		'XI',
		'XII'
	);

	return  $bln[$bulan];
}


// -----------------------------------------------------------------------------
function getUserbyId($id)
{
	$CI = &get_instance();
	return  $CI->db->select('*')->from('users')->where(array('id' => $id))->get()->row_array();
}
// -----------------------------------------------------------------------------
function getProdibyId($id)
{
	$CI = &get_instance();
	return  $CI->db->get_where('prodi', array('id' => $id))->row_array();
}


function getUserPhoto($id)
{
	$CI = &get_instance();
	return $CI->db->get_where('profil', array('id_user' => $id))->row_array()['photo'];
}

function countSurat()
{
	$CI = &get_instance();
	// if ($CI->session->userdata('role') == 1) {
	// 	$prodi = '';
	// 	$in_status = "3,4,5,6,7,8";
	// } else {
	// 	$prodi = "AND p.id_prodi = '" . $CI->session->userdata('id_prodi') . "'";
	// 	if ($CI->session->userdata('role') == 2) { // TU
	// 		$in_status = "3,4,5,6,7";
	// 	} else if ($CI->session->userdata('role') == 5) {
	// 		$in_status = "3,4,5,6,7";
	// 	} else if ($CI->session->userdata('role') == 6) {
	// 		$in_status = "3,4,5,6,7";
	// 	}
	// }
	//WHERE ss.id_surat NOT IN (SELECT ss2.id_surat FROM surat_status ss2 WHERE ss2.id_status IN ($in_status)) AND ss.id_status!='1' $prodi

	// if ($CI->session->userdata('role') == 1) {
	// 	$status = "id_status = 9";
	// 	$prodi = '';
	// } else if ($CI->session->userdata('role') == 2) {
	// 	$status = "(id_status = 2 OR id_status = 5)";
	// 	$prodi = "AND u.id_prodi = '" . $CI->session->userdata('id_prodi') . "'";
	// }

	// $query = $CI->db->query("SELECT COUNT(*) as JUMLAH
	// 	FROM surat_status ss
	// 	LEFT JOIN surat s ON s.id = ss.id_surat
	// 	LEFT JOIN users u ON u.id = s.id_mahasiswa
	// 	WHERE $status $prodi		
	//     ");
	// $result = $query->row_array();

	// return $result['JUMLAH'];

	//return 1;
}
//menampilkan kategori keterangan surat
function kat_keterangan_surat($id)
{
	$CI = &get_instance();
	return $CI->db->get_where('kat_keterangan_surat', array('id' => $id))->row_array();
}

//menampilkan kategori keterangan surat
function generate_form_field($id, $id_surat, $id_status)
{
?>

	<link href="<?= base_url() ?>public/plugins/dm-uploader/dist/css/jquery.dm-uploader.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="<?= base_url() ?>/public/plugins/daterangepicker/daterangepicker.css" />
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

	<?php
	$CI = &get_instance();
	$fields = $CI->db->select('kks.*')->from('kat_keterangan_surat kks')
		->where(array('kks.id' => $id))
		->get()->row_array();


	$value = $CI->db->select('value, verifikasi')->from('keterangan_surat')
		->where(array('id_kat_keterangan_surat' => $fields['id'], 'id_surat' => $id_surat))
		->get()->row_array();

	$field_value = ($value) ? $value['value'] : '0';
	$verifikasi = ($value) ? $value['verifikasi'] : '0';

	if ($fields['type'] == 'file') {

		$image_id = (validation_errors()) ? set_value('dokumen[' . $id . ']') :  $field_value;

		$media = $CI->db->select('*')->from('media')
			->where(array('id' => $image_id))->get()->row_array();

		if ($media) {
			$image = $media['file'];
			$thumb = $media['thumb'];
			$exploded = explode("/", $image);
			$file_name = $exploded[2];
		} else {
			$image = '';
			$file_name = '';
		}


		if (validation_errors()) { // cek adakah eror validasi
			// kondisional di bawah untuk memeriksa, erornya pada field ini ataukah pada field lain
			if (set_value('dokumen[' . $id . ']')) {
				// error di field lain       
				$form = 'd-none';
				$listing = 'd-block';
				$error = '';
			} else {
				// error di field ini
				$form = '';
				$listing = 'd-none';
				$error = 'is-invalid';
			}
		} else {
			//tampilan default, saat value field 0, atau field sudah ada isinya dan menunggu verifikasi
			if ($field_value) {
				//field sudah dicek, tapi perlu direvisi
				if ($verifikasi == 0 && $id_status == 4) {
					//field memiliki isi
					$form = '';
					$listing = 'd-none';
					$error = 'is-invalid';
				} else {
					$form = 'd-none';
					$listing = 'd-flex';
					$error = '';
				}
			} else {
				//field kosong
				$form = '';
				$listing = 'd-none';
				$error = '';
			}
		}

	?>

		<!-- pad akondisi default (data value kosong), form dNd muncul, listing tidak muncul -->
		<input type="hidden" class="id-dokumen-<?= $id; ?> <?= (form_error('dokumen[' . $id . ']')) ? 'is-invalid' : ''; ?> <?= (($verifikasi == 0) && ($id_status == 4)) ? 'is-invalid' : ''; ?>" value="<?= (validation_errors()) ? set_value('dokumen[' . $id . ']') : (($verifikasi == 0) && ($id_status == 4) ? '' : $field_value);  ?>" id="input-<?= $id; ?>" name="dokumen[<?= $id; ?>]" <?= ($id_status == 1 || $id_status == 2 || $id_status == 4 && $verifikasi == 0) ? "" : "disabled"; ?> />

		<div class="tampilUploader">
			<div id="drag-and-drop-zone-<?= $id; ?>" class="dm-uploader p-3 <?= $form; ?> <?= $error; ?>">
				<h5 class="mb-2 mt-2 text-muted">Seret &amp; lepaskan berkas di sini</h5>

				<div class="btn btn-primary btn-block mb-2">
					<span>Atau klik untuk mengunggah</span>
					<input type="file" title='Klik untuk mengunggah' />
				</div>
			</div><!-- /uploader -->

			<span class="text-danger error"><?php echo form_error('dokumen[' . $id . ']'); ?></span>

			<ul class="list-unstyled p-2 d-flex flex-column col mt-2" id="files-<?= $id; ?>" style="border:1px solid #ddd; border-radius:4px;">
				<li class="text-muted text-center empty <?= (validation_errors()) ? (set_value('dokumen[' . $id . ']') ? 'd-none' : 'ga ada value') :  'd-none'  ?>">Belum ada file yang diupload.</li>

				<li class="<?= (($verifikasi == 0) && ($id_status == 4)) ? '' : 'd-none'; ?> error-revisi"> <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> <?= $fields['kat_keterangan_surat'] ?> perlu direvisi. Silakan unggah kembali.</span></li>
				<li class="media <?= $listing; ?> ">

					<?php
					if (set_value('dokumen[' . $id . ']')) {
						$id_file = set_value('dokumen[' . $id . ']');
					} else {
						$id_file = $field_value;
					}

					$file = get_file($id_file);
					if ($file) {
						$filename = explode('/dokumen/', $file['file']);
						$thumb = $file['thumb'];
					} else {
						$thumb = '';
					}
					?>

					<div style="background:url(<?= ($thumb) ? base_url($thumb) : ''; ?>) center top no-repeat;width:100px; height:100px;margin-right:20px;"></div>
					<div class="media-body mb-1">
						<p class="mb-2">

							<strong><?= ($file) ? $filename['1'] : ''; ?></strong> <span class="text-muted"></span>
						</p>
						<div class="buttonedit"> <a class='btn btn-sm btn-warning' target='_blank' href='<?= ($file) ? base_url($file['file']) : ''; ?>'><i class='fas fa-eye'></i> Lihat</a> <a href='<?= base_url('mahasiswa/surat'); ?>/hapus_file/' class='deleteUser-<?= $id; ?> btn btn-sm btn-danger <?= $form; ?>' data-id='<?= $file['id']; ?>'> <i class='fas fa-pencil-alt'></i> Ganti</a></div>
					</div>
				</li>
			</ul>
		</div>


		<script>
			// Changes the status messages on our list
			function ui_multi_update_file_status(id, status, message) {
				$('#uploaderFile' + id).find('span').html(message).prop('class', 'status text-' + status);
			}

			$(function() {
				/*
				 * For the sake keeping the code clean and the examples simple this file
				 * contains only the plugin configuration & callbacks.
				 * 
				 * UI functions ui_* can be located in: demo-ui.js
				 */
				$('#drag-and-drop-zone-<?= $id; ?>').dmUploader({ //
					url: '<?= base_url('mahasiswa/surat'); ?>/doupload',
					maxFileSize: 3000000, // 3 Megs 
					extFilter: ['jpg', 'jpeg', 'png', 'pdf'],
					onDragEnter: function() {
						// Happens when dragging something over the DnD area
						this.addClass('active');
					},
					onDragLeave: function() {
						// Happens when dragging something OUT of the DnD area
						this.removeClass('active');
					},
					onInit: function() {
						// Plugin is ready to use
					},
					onComplete: function() {
						// All files in the queue are processed (success or error)
					},
					onNewFile: function(id, file) {

						var reader = new FileReader();
						var url = '<?= base_url("public/dist/img/pdf.png"); ?>';

						console.log(file);
						// When a new file is added using the file selector or the DnD area
						var template = '<li class="media" id="uploaderFile' + id + '"><div class="bg-file-<?= $id; ?>" style="background-position: center center;background-repeat: no-repeat;width:100px; height:100px;margin-right:20px;margin-bottom:20px;"></div><div class="media-body mb-1"><p class="mb-2"><strong>' + file.name + '</strong> - Status: <span class="text-muted">Waiting</span></p><div class="buttonedit-<?= $id; ?>"></div></div></li>';

						$('#files-<?= $id; ?>').prepend(template);
					},
					onBeforeUpload: function(id) {
						// about tho start uploading a file
						ui_multi_update_file_status(id, 'uploading', '<img width="40px" height="" src="<?= base_url() ?>/public/dist/img/spinners.gif" />');
					},
					onUploadCanceled: function(id) {
						// Happens when a file is directly canceled by the user.
						ui_multi_update_file_status(id, 'warning', 'Canceled by User');

					},
					onUploadProgress: function(id, percent) {},
					onUploadSuccess: function(id, data) {
						// A file was successfully uploaded
						ui_multi_update_file_status(id, 'success', '<i class="fas fa-check-circle"></i>');

						var response = JSON.stringify(data);
						var obj = JSON.parse(response);
						var url_bg = 'url(<?= base_url(); ?>' + obj.thumb + ')';

						$('.id-dokumen-<?= $id; ?>').val(obj.id);
						$('.deleteUser').removeClass('d-none', '3000');
						var button = "<a class='btn btn-sm btn-warning' target='_blank' href='<?= base_url(); ?>" + obj.orig + "'><i class='fas fa-eye'></i> Lihat</a> <a href='<?= base_url('mahasiswa/surat'); ?>/hapus_file/' class='deleteUser-<?= $id; ?> btn btn-sm btn-danger' data-id='" + obj.id + "'> <i class='fas fa-pencil-alt'></i> Ganti</a>";
						$('.buttonedit-<?= $id; ?>').prepend(button);
						$('#drag-and-drop-zone-<?= $id; ?>').fadeOut('400');
						$('.error-revisi').hide();
						$('.bg-file-<?= $id; ?>').css('background-image', url_bg);

					},
					onUploadError: function(id, xhr, status, message) {
						ui_multi_update_file_status(id, 'danger', message);
					},
					onFileExtError: function(id, file) {
						$('#files-<?= $id; ?>').find('li.empty').html('<i class="fas fa-exclamation-triangle"></i> File tidak didukung').removeClass('text-muted').addClass('text-danger');
					},
					onFileSizeError: function(id, file) {

						$('#files-<?= $id; ?>').find('li.empty').html('<i class="fas fa-exclamation-triangle"></i> File terlalu besar').removeClass('text-muted').addClass('text-danger');

					}
				});
			});
			$('body').on('click', 'a.deleteUser-<?= $id; ?>', function(e) {
				e.preventDefault();
				var href = $(this).attr("href");
				var ele = $(this).parents('.media');

				$.ajax({
					url: href,
					type: "POST",
					cache: false,
					data: {
						id: $(this).attr("data-id")
					},
					success: function(dataResult) {
						// alert(dataResult);
						var dataResult = JSON.parse(dataResult);

						console.log(dataResult);
						if (dataResult.statusCode == 200) {
							ele.fadeOut().remove();
							$('#files-<?= $id; ?>').find('div.empty').fadeIn();
							$('#drag-and-drop-zone-<?= $id; ?>').fadeIn('400');
							$('#drag-and-drop-zone-<?= $id; ?>').removeClass('d-none');
							$('#files-<?= $id; ?>').find('li.empty').show();
							$('.id-dokumen-<?= $id; ?>').val('');
						}
					}
				});

			});
		</script>

	<?php } elseif ($fields['type'] == 'textarea') {  ?>

		<textarea class="form-control 
		<?= (form_error('dokumen[' . $id . ']')) ? 'is-invalid' : ''; ?> 
		<?= (($verifikasi == 0) && ($id_status == 4)) ? 'is-invalid' : ''; ?>" id="input-<?= $id; ?>" name="dokumen[<?= $id; ?>]" <?= ($id_status == 1 && $verifikasi == 0 || $id_status == 4 && $verifikasi == 0) ? "" : "disabled"; ?>><?= (validation_errors()) ? set_value('dokumen[' . $id . ']') :  $field_value;  ?></textarea>
		<span class="text-danger"><?php echo form_error('dokumen[' . $id . ']'); ?></span>

	<?php } elseif ($fields['type'] == 'text') {  ?>

		<input type="text" class="form-control" value="<?= (validation_errors()) ? set_value('dokumen[' . $id . ']') :  $field_value;  ?>" <?= (form_error('dokumen[' . $id . ']')) ? 'is-invalid' : ''; ?> <?= (($verifikasi == 0) && ($id_status == 4)) ? 'is-invalid' : ''; ?>" id="input-<?= $id; ?>" name="dokumen[<?= $id; ?>]" <?= ($id_status == 1 && $verifikasi == 1 || $id_status == 4 && $verifikasi == 1) ? "" : "disabled"; ?> />
		<span class="text-danger"><?php echo form_error('dokumen[' . $id . ']'); ?></span>


	<?php } elseif ($fields['type'] == 'date_range') { ?>

		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.1/moment.min.js"></script>

		<script type="text/javascript" src="<?= base_url() ?>/public/plugins/daterangepicker/daterangepicker.js"></script>
		<link rel="stylesheet" type="text/css" href="<?= base_url() ?>/public/plugins/daterangepicker/daterangepicker.css" />

		<input type="text" class="form-control" value="<?= (validation_errors()) ? set_value('dokumen[' . $id . ']') :  $field_value;  ?>" <?= (form_error('dokumen[' . $id . ']')) ? 'is-invalid' : ''; ?> <?= (($verifikasi == 0) && ($id_status == 4)) ? 'is-invalid' : ''; ?>" id="input-<?= $id; ?>" name="dokumen[<?= $id; ?>]" <?= ($id_status == 1 && $verifikasi == 0 || $id_status == 4 && $verifikasi == 0) ? "" : "disabled"; ?> />

		<script type="text/javascript">
			$(function() {

				$('#input-<?= $id; ?>').daterangepicker({
					autoUpdateInput: false,
					locale: {
						cancelLabel: 'Clear'
					}
				});

				$('#input-<?= $id; ?>').on('apply.daterangepicker', function(ev, picker) {
					$(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
				});

				$('#input-<?= $id; ?>').on('cancel.daterangepicker', function(ev, picker) {
					$(this).val('');
				});

			});
		</script>

		<span class="text-danger"><?php echo form_error('dokumen[' . $id . ']'); ?></span>

	<?php } elseif ($fields['type'] == 'ta') { //tahun akademik 
	?>
		<select class="form-control
		<?= (form_error('dokumen[' . $id . ']')) ? 'is-invalid' : ''; ?> 
		<?= (($verifikasi == 0) && ($id_status == 4)) ? 'is-invalid' : ''; ?>" name="dokumen[<?= $id; ?>]" id="input-<?= $id; ?>">
			<option value=""> -- Pilih Tahun Akademik -- </option>
			<?php
			$cur_year = date("Y");
			$cur_semester = (date("n") <= 6) ?  $cur_year - 1 : $cur_year;
			for ($x = $cur_semester; $x <= $cur_year + 1; $x++) {
				$value_select = sprintf("%d / %d", $x, $x + 1); ?>
				<option value="<?= $value_select; ?>" <?= (validation_errors()) ? set_select('dokumen[' . $id . ']', $value_select) : ""; ?> <?= ($field_value == $value_select) ? "selected" : ""; ?>><?= $x; ?> / <?= $x + 1; ?></option>
			<?php  }
			?>
		</select>
		<span class="text-danger"><?php echo form_error('dokumen[' . $id . ']'); ?></span>

	<?php } elseif ($fields['type'] == 'sem') { //tahun akademik 
	?>
		<select class="form-control
		<?= (form_error('dokumen[' . $id . ']')) ? 'is-invalid' : ''; ?> 
		<?= (($verifikasi == 0) && ($id_status == 4)) ? 'is-invalid' : ''; ?>" name="dokumen[<?= $id; ?>]" id="input-<?= $id; ?>">
			<option value=""> -- Pilih Semester -- </option>
			<?php
			$cur_year = date("Y");
			$cur_semester = (date("n") <= 6) ?  "Genap" : "Ganjil";
			?>
			<option value="Ganjil" <?= (validation_errors()) ? set_select('dokumen[' . $id . ']', "Ganjil") : ""; ?><?= ($field_value == "Ganjil") ? "selected" : ""; ?>>Ganjil</option>
			<option value="Genap" <?= (validation_errors()) ? set_select('dokumen[' . $id . ']', "Genap") : ""; ?> <?= ($field_value == "Genap") ? "selected" : ""; ?>>Genap</option>
		</select>
		<span class="text-danger"><?php echo form_error('dokumen[' . $id . ']'); ?></span>

		<!--  Piih Pembimbing -->
	<?php } elseif ($fields['type'] == 'select_pembimbing') { //tahun akademik 
	?>

		<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

		<select class="<?= $fields['key']; ?> form-control <?= (form_error('dokumen[' . $id . ']')) ? 'is-invalid' : ''; ?> <?= (($verifikasi == 0) && ($id_status == 4)) ? 'is-invalid' : ''; ?>" id="input-<?= $id; ?>" name="dokumen[<?= $id; ?>]" <?= ($id_status == 1 && $verifikasi == 0 || $id_status == 4 && $verifikasi == 0) ? "" : "disabled"; ?>>
			<option value="<?= $field_value; ?>"><?= getUserbyId($field_value)['fullname']; ?></option>
		</select>
		<span class="text-danger"><?php echo form_error('dokumen[' . $id . ']'); ?></span>

		<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
		<script>
			$(document).ready(function() {
				$('.<?= $fields['key']; ?>').select2({
					ajax: {
						url: '<?= base_url('mahasiswa/surat/getpembimbing'); ?>',
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
					placeholder: 'Pilih Dosen Pembimbing',
					minimumInputLength: 3,
					// templateResult: formatRepo,
					// templateSelection: formatRepoSelection
				});
			});
		</script>

		<!-- <select class="form-control
		<?= (form_error('dokumen[' . $id . ']')) ? 'is-invalid' : ''; ?> 
		<?= (($verifikasi == 0) && ($id_status == 4)) ? 'is-invalid' : ''; ?>" name="dokumen[<?= $id; ?>]" id="input-<?= $id; ?>" <?= ($id_status == 1 && $verifikasi == 0 || $id_status == 4 && $verifikasi == 0) ? "" : "disabled"; ?>>
			<option value=""> -- Pilih Dosen -- </option>
			<?php
			$CI = &get_instance();
			$CI->db->order_by('id', 'DESC');
			$dosen = $CI->db->get_where('users', array('role' => 4))->result_array();

			foreach ($dosen as $dosen) {
			?>
				<option value="<?= $dosen['id'] ?>" <?= (validation_errors()) ? set_select('dokumen[' . $id . ']',  $dosen['id']) : ""; ?><?= ($field_value ==  $dosen['id']) ? "selected" : ""; ?>><?= $dosen['fullname'] ?></option>
			<?php } ?>
		</select> -->
		<span class="text-danger"><?php echo form_error('dokumen[' . $id . ']'); ?></span>
	<?php } ?>

	<script src="<?= base_url() ?>/public/plugins/dm-uploader/dist/js/jquery.dm-uploader.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.1/moment.min.js"></script>
	<script type="text/javascript" src="<?= base_url() ?>/public/plugins/daterangepicker/daterangepicker.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

	<?php
}

//menampilkan kategori keterangan surat
function generate_keterangan_surat($id, $id_surat, $id_status)
{
	$CI = &get_instance();
	$fields = $CI->db->select('kks.*')->from('kat_keterangan_surat kks')
		->where(array('kks.id' => $id))
		->get()->row_array();


	$value = $CI->db->select('value, verifikasi')->from('keterangan_surat')
		->where(array('id_kat_keterangan_surat' => $fields['id'], 'id_surat' => $id_surat))
		->get()->row_array();

	$field_value = ($value) ? $value['value'] : '0';
	$verifikasi = ($value) ? $value['verifikasi'] : '0';


	if ($fields['type'] == 'file') {

		$image_id = (validation_errors()) ? set_value('dokumen[' . $id . ']') :  $field_value;

		$media = $CI->db->select('*')->from('media')
			->where(array('id' => $image_id))->get()->row_array();

		if ($media) {
			$image = $media['file'];
			$thumb = $media['thumb'];
			$exploded = explode("/", $image);
			$file_name = $exploded[2];
		} else {
			$image = '';
			$file_name = '';
		}


	?>

		<div class="media mb-4 p-2" style="border-radius:4px; <?= (($verifikasi == 0) && ($id_status == 4)) ? 'border:1px solid red; ' : 'border:1px solid #ddd'; ?>">
			<div style="background:url(<?= ($thumb) ? base_url($thumb) : ''; ?>) center top no-repeat;width:100px; height:100px;margin-right:20px;"></div>
			<div class="media-body p-2 mb-2">
				<p><strong><?= isset($file_name) ? $file_name : ''; ?></strong></p>
				<a class='btn btn-sm btn-warning' target='_blank' href='<?= base_url($thumb); ?>'><i class='fas fa-eye'></i> Lihat</a>
			</div>
		</div>
		<?php if ((($id_status == 2 && $verifikasi == 0) || ($id_status == 5 && $verifikasi == 0))

			&& ($CI->session->userdata('role') == 2)

		) { ?>
			<div class="d-inline">
				<input type="hidden" name="verifikasi[<?= $id; ?>]" value="0" />
				<label class="switch">
					<input type="checkbox" class="verifikasi" name="verifikasi[<?= $id; ?>]" value="1" <?= ($verifikasi == 1) ? 'checked' : '';  ?> />
					<span class="slider round"></span>
				</label>

			</div>
			<div class="d-inline">
				Data sudah sesuai? <a class="help" data-toggle="tooltip" data-placement="right" title="Klik tombol di samping jika data sudah sesuai"><i class="fa fa-info-circle"></i></a>
			</div>
		<?php }
	} elseif ($fields['type'] == 'textarea') { ?>

		<textarea class="form-control mb-2" id="input-<?= $id; ?>" disabled><?= $field_value;  ?></textarea>

		<?php if ((($id_status == 2 && $verifikasi == 0) || ($id_status == 5 && $verifikasi == 0))
			&& $CI->session->userdata('role') == 2
		) { ?>
			<div class="d-inline">
				<input type="hidden" name="verifikasi[<?= $id; ?>]" value="0" />
				<label class="switch">
					<input type="checkbox" class="verifikasi" name="verifikasi[<?= $id; ?>]" value="1" <?= ($verifikasi == 1) ? 'checked' : ''; ?> />
					<span class="slider round"></span>
				</label>
			</div>
			<div class="d-inline">
				Data sudah sesuai? <a class="help" data-toggle="tooltip" data-placement="right" title="Klik tombol di samping jika data sudah sesuai"><i class="fa fa-info-circle"></i></a>
			</div>

		<?php }
	} elseif ($fields['type'] == 'text') { ?>

		<input type="text" class="form-control mb-2" id="input-<?= $id; ?>" disabled value="<?= $field_value;  ?>" />

		<?php if ((($id_status == 2 && $verifikasi == 0) || ($id_status == 5 && $verifikasi == 0))
			&& $CI->session->userdata('role') == 2
		) { ?>

			<div class="d-inline">
				<input type="hidden" name="verifikasi[<?= $id; ?>]" value="0" />
				<label class="switch">
					<input type="checkbox" class="verifikasi" name="verifikasi[<?= $id; ?>]" value="1" <?= ($verifikasi == 1) ? 'checked' : ''; ?> />
					<span class="slider round"></span>
				</label>
			</div>
			<div class="d-inline">
				Data sudah sesuai? <a class="help" data-toggle="tooltip" data-placement="right" title="Klik tombol di samping jika data sudah sesuai"><i class="fa fa-info-circle"></i></a>
			</div>

		<?php }
	} elseif ($fields['type'] == 'date_range') { ?>

		<input type="text" class="form-control mb-2" id="input-<?= $id; ?>" disabled value="<?= $field_value;  ?>" />

		<?php if ((($id_status == 2 && $verifikasi == 0) || ($id_status == 5 && $verifikasi == 0))
			&& $CI->session->userdata('role') == 2
		) { ?>

			<div class="d-inline">
				<input type="hidden" name="verifikasi[<?= $id; ?>]" value="0" />
				<label class="switch">
					<input type="checkbox" class="verifikasi" name="verifikasi[<?= $id; ?>]" value="1" <?= ($verifikasi == 1) ? 'checked' : ''; ?> />
					<span class="slider round"></span>
				</label>
			</div>
			<div class="d-inline">
				Data sudah sesuai? <a class="help" data-toggle="tooltip" data-placement="right" title="Klik tombol di samping jika data sudah sesuai"><i class="fa fa-info-circle"></i></a>
			</div>

		<?php }
	} elseif ($fields['type'] == 'sem') { ?>


		<input type="text" class="form-control mb-2" id="input-<?= $id; ?>" disabled value="<?= $field_value;  ?>"></input>
		<?php if ((($id_status == 2 && $verifikasi == 0) || ($id_status == 5 && $verifikasi == 0))
			&& $CI->session->userdata('role') == 2
		) { ?>
			<div class="d-inline">
				<input type="hidden" name="verifikasi[<?= $id; ?>]" value="0" />
				<label class="switch">
					<input type="checkbox" class="verifikasi" name="verifikasi[<?= $id; ?>]" value="1" <?= ($verifikasi == 1) ? 'checked' : ''; ?> />
					<span class="slider round"></span>
				</label>
			</div>
			<div class="d-inline">
				Data sudah sesuai? <a class="help" data-toggle="tooltip" data-placement="right" title="Klik tombol di samping jika data sudah sesuai"><i class="fa fa-info-circle"></i></a>
			</div>

		<?php }
	} elseif ($fields['type'] == 'ta') { ?>

		<input type="text" class="form-control mb-2" id="input-<?= $id; ?>" disabled value="<?= $field_value;  ?>"></input>

		<?php if ((($id_status == 2 && $verifikasi == 0) || ($id_status == 5 && $verifikasi == 0))
			&& $CI->session->userdata('role') == 2
		) { ?>
			<div class="d-inline">
				<input type="hidden" name="verifikasi[<?= $id; ?>]" value="0" />
				<label class="switch">
					<input type="checkbox" class="verifikasi" name="verifikasi[<?= $id; ?>]" value="1" <?= ($verifikasi == 1) ? 'checked' : ''; ?> />
					<span class="slider round"></span>
				</label>
			</div>
			<div class="d-inline">
				Data sudah sesuai? <a class="help" data-toggle="tooltip" data-placement="right" title="Klik tombol di samping jika data sudah sesuai"><i class="fa fa-info-circle"></i></a>
			</div>

		<?php }
	} elseif ($fields['type'] == 'select_pembimbing') {

		$CI = &get_instance();
		$dosen = $CI->db->get_where('users', array('id' => $field_value))->row_array();
		?>

		<input type="text" class="form-control mb-2" id="input-<?= $id; ?>" disabled value="<?= $dosen['fullname'];  ?>"></input>

		<?php if ((($id_status == 2 && $verifikasi == 0) || ($id_status == 5 && $verifikasi == 0))
			&& $CI->session->userdata('role') == 2
		) { ?>
			<div class="d-inline">
				<input type="hidden" name="verifikasi[<?= $id; ?>]" value="0" />
				<label class="switch">
					<input type="checkbox" class="verifikasi" name="verifikasi[<?= $id; ?>]" value="1" <?= ($verifikasi == 1) ? 'checked' : ''; ?> />
					<span class="slider round"></span>
				</label>
			</div>
			<div class="d-inline">
				Data sudah sesuai? <a class="help" data-toggle="tooltip" data-placement="right" title="Klik tombol di samping jika data sudah sesuai"><i class="fa fa-info-circle"></i></a>
			</div>

	<?php }
	} // endif fields 
	?>


<?php }

function badge_status($status)
{
	$CI = &get_instance();
	$status  = $CI->db->get_where('status', array('id' => $status))->row_array();

	return '<span class="float-right badge-sm badge badge-' . $status['badge'] . '"> ' . $status['status'] . ' </span>';
}
function tgl_status_surat($id_surat, $status)
{
	$CI = &get_instance();
	return  $status  = $CI->db->select("DATE_FORMAT(date,'%d %M %Y') as date, DATE_FORMAT(date,'%H:%i') as time")->from('surat_status')->where(array('id_surat' => $id_surat, 'id_status' => $status))->get()->row_array();
}

function cek_verifikasi($id_surat)
{
	$CI = &get_instance();
	$verifikasi  = $CI->db->select("verifikasi")->from('keterangan_surat')->where(array('id_surat' => $id_surat))->get()->result_array();
	if (array_search("0", array_column($verifikasi, 'verifikasi')) !== false) {
		return true;
	}
}

function get_meta_value($key, $id_surat, $image)
{
	$CI = &get_instance();
	// $id = $CI->db->select("id")->from('kat_keterangan_surat')->where(array('key' => $key))->get()->row_array()['id'];

	// $value = $CI->db->select("value")->from('keterangan_surat')->where(array('id_kat_keterangan_surat' => $id))->get()->row_array()['value'];

	$value = $CI->db->select("kat_keterangan_surat.id, keterangan_surat.value ")
		->from('kat_keterangan_surat')
		->join('keterangan_surat', 'kat_keterangan_surat.id=keterangan_surat.id_kat_keterangan_surat', 'left')
		->where(array("key" => $key))
		->get()
		->row_array();

	if ($image == true) {
		$media = $CI->db->select("file")->from('media')->where(array('id' => $value['value']))->get()->row_array()['file'];
		return $media;
	} else {
		return $value['value'];
	}
}

function get_meta_name($key)
{
	$CI = &get_instance();
	$name = $CI->db->select("kat_keterangan_surat")
		->from('kat_keterangan_surat')
		->where(array('key' => $key))
		->get()
		->row_array()['kat_keterangan_surat'];

	return $name;
}



function get_dokumen_syarat($id_surat)
{
	$CI = &get_instance();
	$dokumen = $CI->db->select("kat_keterangan_surat.id, kat_keterangan_surat.kat_keterangan_surat, keterangan_surat.value, media.file")
		->from('kat_keterangan_surat')
		->join('keterangan_surat', 'kat_keterangan_surat.id=keterangan_surat.id_kat_keterangan_surat', 'left')
		->join('media', 'media.id=keterangan_surat.value', 'left')
		->where(array('type' => "file", "id_surat" => $id_surat))
		->get()
		->result_array();

	return $dokumen;



	// $value = $CI->db->select("value")->from('keterangan_surat')->where(array('id_kat_keterangan_surat' => $id))->get()->row_array()['value'];

	// if ($image == true) {

	// 	$media = $CI->db->select("file")->from('media')->where(array('id' => $value))->get()->row_array()['file'];

	// 	return $media;
	// } else {
	// 	return $value;
	// }
}

// fungsi ini memeriksa apakah mhs udah pernah buat surat, jika sudah maka tidak diperkenankan membuat lagi sampai surat tersebut selesai
// cek juga jika mhs mengajukan surat yg berkaitan dgn durasi (contoh cuti kuliah), maka mhs tidak bs mengajukan cuti lagi sampai
// dalam posisi mahasiswa aktif

function cek_semester()
{
	$CI = &get_instance();
	//ambil tahun
	$cur_semester_angka = (date("n") <= 6) ?  2 : 1;
	$semester = date("Y") . $cur_semester_angka;
	$angkatan = substr($CI->session->userdata('username'), 0, 4);

	if ($semester % 2 != 0) {
		$a = (($semester + 10) - 1) / 10;
		$b = $a - $angkatan;
		$c = ($b * 2) - 1;
	} else {
		$a = (($semester + 10) - 2) / 10;
		$b = $a - $angkatan;
		$c = $b * 2;
	}

	return $c;
}

function cek_sudah_buat_surat($id_mahasiswa, $id_kategori_surat, $min_semester)
{
	//cek apakah ada kategori surat yg blm selesai
	$CI = &get_instance();

	$surat = $CI->db->query("SELECT s.*, ks.min_semester, ss.id_status FROM surat s
		LEFT JOIN kategori_surat ks ON ks.id=s.id_kategori_surat
		LEFT JOIN surat_status ss ON ss.id_surat=s.id
		WHERE id_mahasiswa = $id_mahasiswa AND id_kategori_surat = $id_kategori_surat ORDER BY id
		DESC LIMIT 1
		")->row_array();

	//jika ada surat yg belum selesai/ belum pernah mengajukan surat
	if ($surat) {

		$id_surat = $surat['id'];
		// jika sdh mengajukan, cek status surat, jika statusnya blm selesai (>10) maka belum boleh membuat surat yg sama

		$status = $CI->db->query("SELECT DATE, id_status FROM surat_status
  	WHERE id_surat = $id_surat
  	ORDER BY date
  	DESC LIMIT 1	
		")->row_array();

		//status 10 = selesai
		//status 6 = ditolak
		if (($status['id_status'] == 10) || ($status['id_status']  == 6)) {
			$diperbolehkan = 1;
		} else {
			$diperbolehkan = 2;
		}
	} else {
		//cek apakah option min_semester ada
		if ($min_semester > 0) {
			if (cek_semester() >= $min_semester) {;
				$diperbolehkan = 1;
			} else {
				$diperbolehkan = 3;
			}
		} else {
			$diperbolehkan = 1;
		}
	}
	return $diperbolehkan;
}


function tampil_notif()
{

	//cek apakah ada kategori surat yg blm selesai
	$CI = &get_instance();
	if ($_SESSION['role'] == 1) {
		$where = "n.role = 1";
	} else if ($_SESSION['role'] == 2) {
		$where = "n.role = 2 AND n.id_prodi = " . $_SESSION['id_prodi'];
	} else if ($_SESSION['role'] == 3) {
		$where = "n.role = 3 AND n.kepada = " . $_SESSION['user_id'];
	} else if ($_SESSION['role'] == 4) {
		$where = "n.role = 4 AND n.kepada = " . $_SESSION['user_id'];
	} else if ($_SESSION['role'] == 5) {
		$where = "n.role = 5";
	} else if ($_SESSION['role'] == 6) {
		$where = "n.role = 6 AND n.id_prodi = " . $_SESSION['id_prodi'];
	}
	$notif = $CI->db->query("SELECT n.*, n.id as notif_id, sp.judul_notif, DATE_FORMAT(n.tanggal, '%H:%i') as time,  DATE_FORMAT(n.tanggal, '%d %M') as date_full, sp.badge, sp.icon, s.id_kategori_surat, ks.kategori_surat, u.fullname
	FROM notif n 	
	LEFT JOIN status_pesan sp ON sp.id = n.id_status_pesan
	LEFT JOIN surat s ON s.id = n.id_surat
	LEFT JOIN kategori_surat ks ON s.id_kategori_surat = ks.id
	LEFT JOIN users u ON n.kepada = u.id
	WHERE  $where AND n.status = 0 	
	ORDER BY id DESC");

	// echo '<pre>';
	// print_r($notif->result_array());
	// echo '</pre>';

?>
	<!-- Nav Item - Alerts -->
	<li class="nav-item dropdown no-arrow mx-1">
		<a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			<i class="fas fa-bell fa-fw"></i>
			<!-- Counter - Alerts -->
			<?php
			$notif_count = $notif->num_rows();
			if ($notif_count > 0) { ?>
				<span class="badge badge-danger badge-counter"><?php echo $notif->num_rows(); ?></span>
			<?php } ?>
		</a>
		<!-- Dropdown - Alerts -->
		<div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
			<h6 class="dropdown-header">
				Notifikasi
			</h6>

			<?php
			if ($notif_count > 0) {
				foreach ($notif->result_array() as $notif) {
			?>
					<a class="dropdown-item d-flex align-items-center" href="<?= base_url('notif/detail/' . $notif['notif_id']); ?>">
						<div>

							<div class="small text-gray-500"><?= $notif['date_full']; ?> <?= $notif['time']; ?></div>
							<span class="font-weight-bold text-<?= $notif['badge']; ?>"> <i class="<?= $notif['icon']; ?>"></i> <?= $notif['judul_notif']; ?> </span> &raquo; <span class="font-weight-bold"><?= $notif['kategori_surat']; ?> </span>
							<span class="font-weight-normal">(<?= $notif['fullname']; ?>)</span>

						</div>
					</a>

				<?php } // end foreach
			} else { ?>
				<a class="dropdown-item d-flex align-items-center" href="#">
					<div>
						<span class="text-gray-500">Belum ada notifikasi</span>
					</div>
				</a>
			<?php	}	?>

			<a class="dropdown-item text-center medium text-gray-500" href="<?= base_url('notif'); ?>">Lihat semua Notifikasi</a>
		</div>
	</li>
<?php
}

function tampil_alert($status, $role)
{

	$CI = &get_instance();
	$alert = $CI->db->select('s.*,sp.*')->from('status s')
		->join('status_pesan sp', 's.id=sp.id_status', 'left')
		->where(array('s.id =' => $status, 'sp.role' => $role))->get()->row_array();
?>
	<p class="alert alert-<?= $alert['badge']; ?> mb-4"><i class="<?= $alert['icon']; ?>"></i> <?= $alert['alert']; ?></p>
<?php }


function get_file($id)
{
	$CI = &get_instance();
	return	$media = $CI->db->select("*")->from('media')->where(array('id' => $id))->get()->row_array();
}
