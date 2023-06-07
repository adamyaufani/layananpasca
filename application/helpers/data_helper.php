<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function profPic($id, $w)
{
	if ($id) {
		$year = substr($id, 0, 4);
		// $pic = '<div style="width:' . $w . 'px;height:' . $w . 'px; background:url(https://krs.umy.ac.id/FotoMhs/' . $year . '/' . $id . '.jpg) center top no-repeat; background-size:100%;" class="img-profile rounded-circle"></div>';
		$pic = "";
	} else {
		$pic = '<div style="width:' . $w . 'px;height:' . $w . 'px; background:url(https://source.unsplash.com/QAB-WJcbgJk/60x60) center top no-repeat; background-size:100%;" class="img-profile rounded-circle"></div>';
	}

	return $pic;
}

if (!function_exists('date_time')) {
	function date_time($datetime)
	{
		return date('F j, Y', strtotime($datetime));
	}
}

function tgl_indo($tanggal)
{
	$bulan = array(
		1 =>   'Januari',
		'Februari',
		'Maret',
		'April',
		'Mei',
		'Juni',
		'Juli',
		'Agustus',
		'September',
		'Oktober',
		'November',
		'Desember'
	);
	$pecahkan = explode('-', $tanggal);

	// variabel pecahkan 0 = tanggal
	// variabel pecahkan 1 = bulan
	// variabel pecahkan 2 = tahun

	return $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
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
function getDosenbyId($id)
{
	$CI = &get_instance();
	$db2 = $CI->load->database('dbsqlsrv', TRUE);
	return $db2->query("SELECT * from V_Import_Simpegawai WHERE id_pegawai ='$id' ")->row_array();
}
// -----------------------------------------------------------------------------
function getUserMhsbyId($id)
{
	$CI = &get_instance();
	$db2 = $CI->load->database('dbsqlsrv', TRUE);

	return $db2->query("SELECT * from V_Simpel_Pasca WHERE STUDENTID ='$id' ")->row_array();
}
// -----------------------------------------------------------------------------
function getUsersbyRole($role, $prodi)
{

	$CI = &get_instance();

	if ($prodi) {
		return  $CI->db->select('id, username, email, role, fullname, aktif, nik, nidn')->from('users')->where(array('role' => $role, 'id_prodi' => $prodi))->get()->result_array();
	} else {
		return  $CI->db->select('id, username, email, role, fullname, aktif, nik, nidn')->from('users')->where(array('role' => $role))->get()->result_array();
	}
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
function getDirektur()
{
	$CI = &get_instance();
	return $CI->db->query("select prodi.id, users.fullname, users.nik from prodi  left join users on prodi.ka_prodi = users.id where prodi.id = 11")->row_array();
}


//menampilkan kategori keterangan surat
function kat_keterangan_surat($id)
{
	$CI = &get_instance();
	return $CI->db->get_where('kat_keterangan_surat', array('id' => $id))->row_array();
}


function field_value_checker($required, $field_value, $id, $verifikasi, $pengajuan_status, $array)
{
	if ($required == 1) {

		if (validation_errors()) { // cek adakah eror validasi
			// kondisional di bawah untuk memeriksa, erornya pada field ini ataukah pada field lain
			if (set_value('dokumen[' . $id . ']')) {
				// error di field lain       
				$value = set_value('dokumen[' . $id . '][]');
				$valid = '';
				$disabled = 'en';
			} else {
				// error di field ini
				$value = set_value('dokumen[' . $id . '][]');
				$valid = 'is-invalid';
				$disabled = 'en';
			}
		} else {
			//tampilan default, saat value field 0, atau field sudah ada isinya dan menunggu verifikasi

			if ($field_value) {

				//field sudah dicek, tapi perlu direvisi
				if ($verifikasi == 0 && $pengajuan_status == 4) {
					$value = $field_value;
					$valid = 'is-invalid';
					$disabled = 'en';
				} else {
					$value = $field_value;
					$valid = 'sasasasa';
					$disabled = 'readonly';
				}
			} else {
				//field kosong
				$value = '';
				$valid = '';
				$disabled = 'en';
			}
		}
	} else {
		if (validation_errors()) { // cek adakah eror validasi
			// kondisional di bawah untuk memeriksa, erornya pada field ini ataukah pada field lain

			// error di field lain       
			$value = set_value('dokumen[' . $id . '][]');
			$valid = '';
			$disabled = 'en';
		} else {
			if ($field_value) {
				//field sudah dicek, tapi perlu direvisi
				if ($verifikasi == 0 && $pengajuan_status == 4) {
					$value = $field_value;
					$valid = 'is-invalid';
					$disabled = 'en';
				} else {
					$value = $field_value;
					$valid = '';
					$disabled = 'readonly';
				}
			} else {
				//field sudah dicek, tapi perlu direvisi
				if ($verifikasi == 0 && $pengajuan_status == 4) {
					$value = $field_value;
					$valid = 'is-invalid';
					$disabled = 'en';
				} else {
					//field kosong
					$value = '';
					$valid = '';
					$disabled = 'en';
				}
			}
		}
	}

	return array(
		'value' => $value,
		'valid' => $valid,
		'disabled' => $disabled
	);
}

//menampilkan Field
function generate_form_field($id, $id_surat, $pengajuan_status, $id_status)
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




	/* FILE UPLOADER*/

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


		if ($fields['required'] == 1) {

			if (validation_errors()) { // cek adakah eror validasi
				// kondisional di bawah untuk memeriksa, erornya pada field ini ataukah pada field lain
				if (set_value('dokumen[' . $id . ']')) {
					// error di field lain       
					$form = 'd-none';
					$listing = 'd-blocks';
					$error = '';
					$change = '';
				} else {
					// error di field ini
					$form = '';
					$listing = 'd-none';
					$error = 'is-invalid';
					$change = '';
				}
			} else {
				//tampilan default, saat value field 0, atau field sudah ada isinya dan menunggu verifikasi
				if ($field_value) {

					//field sudah dicek, tapi perlu direvisi
					if ($verifikasi == 0 && $pengajuan_status == 4) {
						//field memiliki isi
						$form = 'd-none';
						$listing = '';
						$error = 'is-invalid';
						$change = '';
					} else {
						$form = 'd-none';
						$listing = 'd-blocks';
						$error = '';
						$change = 'd-none';
					}
				} else {
					//field kosong
					$form = '';
					$listing = 'd-none';
					$error = '';
					$change = '';
				}
			}
		} else {
			if (validation_errors()) { // cek adakah eror validasi

				// kondisional di bawah untuk memeriksa, erornya pada field ini ataukah pada field lain	
				if (set_value('dokumen[' . $id . ']')) {

					$form = 'd-none';
					$listing = 'd-nones';
					$error = 'is-invalidss';
					$change = '';
				} else {
					// error di field ini

					$form = '';
					$listing = 'd-none';
					$error = '';
					$change = '';
				}
			} else {
				//tampilan default, saat value field 0, atau field sudah ada isinya dan menunggu verifikasi
				if ($field_value) {

					//field sudah dicek, tapi perlu direvisi
					if ($verifikasi == 0 && $pengajuan_status == 4) {
						//field memiliki isi
						$form = '';
						$listing = '';
						$error = 'is-invalid';
						$change = '';
					} else {
						$form = 'd-none';
						$listing = 'd-blocks';
						$error = '';
						$change = 'd-none';
					}
				} else {
					//field kosong
					$form = '';
					$listing = 'd-none';
					$error = '';
					$change = '';
				}
			}
		}

		$check = field_value_checker($fields['required'], $field_value, $id, $verifikasi, $pengajuan_status, false);

?>

		<!-- pad akondisi default (data value kosong), form dNd muncul, listing tidak muncul -->
		<input type="hidden" class="id-dokumen-<?= $id; ?> <?= $check['valid']; ?>" value="<?= $check['value'];  ?>" id="input-<?= $id; ?>" name="dokumen[<?= $id; ?>]" <?= $check['disabled'];  ?> />

		<div class="tampilUploader">
			<div id="drag-and-drop-zone-<?= $id; ?>" class="dm-uploader p-3 <?= $form; ?> <?= $error; ?>">
				<h5 class="mb-2 mt-2 text-muted">Seret &amp; lepaskan berkas di sini</h5>

				<div class="btn btn-primary btn-block mb-2">
					<span>Atau klik untuk mengunggah</span>
					<input type="file" title='Klik untuk mengunggah' />
				</div>
			</div><!-- /uploader -->

			<span class="text-danger error"><?php echo form_error('dokumen[' . $id . ']'); ?></span>

			<ul class="list-unstyled d-flex flex-column col mt-2 p-2" id="files-<?= $id; ?>" style="border-radius: 5px; <?= ($check['valid'] == 'is-invalid') ? 'border:1px solid #b0272b; ' : 'border:1px solid #ddd'; ?>">
				<li class="text-muted text-center empty <?= (validation_errors()) ? (set_value('dokumen[' . $id . ']') ? 'd-none' : 'ga ada value') :  'd-none'  ?>"></li>

				<li class="<?= (($verifikasi == 0) && ($id_status == 4)) ? 'error-revisi' : 'd-none'; ?> "> <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> <?= $fields['kat_keterangan_surat'] ?> perlu direvisi. Silakan unggah kembali.</span></li>
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
						$thumb  = base_url() . 'public/dist/img/pdf.png';
					}
					?>

					<div class="img-thumbnail" style="background:url(<?= ($thumb) ? base_url($thumb) : base_url() . 'public/dist/img/pdf.png'; ?>) center center no-repeat;width:100px; height:100px;margin-right:20px;background-size:180px;"></div>
					<div class="media-body mb-1">
						<p class="mb-2">
							<strong><?= ($file) ? $filename['1'] : ''; ?></strong> <span class="text-muted"></span>
						</p>
						<div class="buttonedit"> <a class='btn btn-sm btn-warning' target='_blank' href='<?= ($file) ? base_url($file['file']) : ''; ?>'><i class='fas fa-eye'></i> Lihat</a> <a href='<?= base_url('mahasiswa/surat'); ?>/hapus_file/' class='deleteUser-<?= $id; ?> btn btn-sm btn-danger <?= $change; ?>' data-id='<?= ($file) ? $file['id'] : ''; ?>'> <i class='fas fa-pencil-alt'></i> Ganti</a></div>
					</div>
				</li>
			</ul>
		</div>


		<script>
			$(document).ready(function() {
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
						extFilter: ['pdf', 'docx'],
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

							// When a new file is added using the file selector or the DnD area
							var template = '<li class="media" id="uploaderFile' + id + '"><div class="bg-file-<?= $id; ?>" style="background-position: center center;background-repeat: no-repeat;width:100px; height:100px;margin-right:20px;margin-bottom:20px;background-size:180px;"></div><div class="media-body mb-1"><p class="mb-2"><strong>' + file.name + '</strong> - Status: <span class="text-muted">Waiting</span></p><div class="buttonedit-<?= $id; ?>"></div></div></li>';

							$('#files-<?= $id; ?>').prepend(template);
						},
						onBeforeUpload: function(id) {
							// about tho start uploading a file
							ui_multi_update_file_status(id, 'uploading', '<img width="40px" height="" src="<?= base_url() ?>public/dist/img/spinners.gif" />');
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

							if (data.extension == '.pdf') {
								var url_bg = 'url(<?= base_url(); ?>public/dist/img/pdf.png)';
							} else {
								var url_bg = 'url(<?= base_url(); ?>' + obj.thumb + ')';
							}

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

							console.log('error');
						},
						onFileExtError: function(id, file) {
							$('#files-<?= $id; ?>').find('li.empty').html('<i class="fas fa-exclamation-triangle"></i> File tidak didukung. Hanya pdf dan docx.').removeClass('text-muted d-none').addClass('text-danger');
							console.log('error ext');
						},
						onFileSizeError: function(id, file) {

							$('#files-<?= $id; ?>').find('li.empty').html('<i class="fas fa-exclamation-triangle"></i> File terlalu besar. Maksimum 2MB').removeClass('text-muted d-none').addClass('text-danger');
							console.log('error size');
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
			});
		</script>

	<?php
		/* IMAGE UPLOADER */

	} elseif ($fields['type'] == 'image') {

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


		if ($fields['required'] == 1) {

			if (validation_errors()) { // cek adakah eror validasi
				// kondisional di bawah untuk memeriksa, erornya pada field ini ataukah pada field lain
				if (set_value('dokumen[' . $id . ']')) {
					// error di field lain       
					$form = 'd-none';
					$listing = 'd-blocks';
					$error = '';
					$change = '';
				} else {
					// error di field ini
					$form = '';
					$listing = 'd-none';
					$error = 'is-invalid';
					$change = '';
				}
			} else {
				//tampilan default, saat value field 0, atau field sudah ada isinya dan menunggu verifikasi
				if ($field_value) {

					//field sudah dicek, tapi perlu direvisi
					if ($verifikasi == 0 && $pengajuan_status == 4) {
						//field memiliki isi
						$form = 'd-none';
						$listing = '';
						$error = 'is-invalid';
						$change = '';
					} else {
						$form = 'd-none';
						$listing = 'd-blocks';
						$error = '';
						$change = 'd-none';
					}
				} else {
					//field kosong
					$form = '';
					$listing = 'd-none';
					$error = '';
					$change = '';
				}
			}
		} else {
			if (validation_errors()) { // cek adakah eror validasi

				// kondisional di bawah untuk memeriksa, erornya pada field ini ataukah pada field lain	
				if (set_value('dokumen[' . $id . ']')) {

					$form = 'd-none';
					$listing = 'd-nones';
					$error = 'is-invalidss';
					$change = '';
				} else {
					// error di field ini

					$form = '';
					$listing = 'd-none';
					$error = '';
					$change = '';
				}
			} else {
				//tampilan default, saat value field 0, atau field sudah ada isinya dan menunggu verifikasi
				if ($field_value) {

					//field sudah dicek, tapi perlu direvisi
					if ($verifikasi == 0 && $pengajuan_status == 4) {
						//field memiliki isi
						$form = '';
						$listing = '';
						$error = 'is-invalid';
						$change = '';
					} else {

						$form = 'd-none';
						$listing = 'd-blocks';
						$error = '';
						$change = 'd-none';
					}
				} else {
					//field kosong
					$form = '';
					$listing = 'd-none';
					$error = '';
					$change = '';
				}
			}
		}

		$check = field_value_checker($fields['required'], $field_value, $id, $verifikasi, $pengajuan_status, false);
	?>

		<!-- pad akondisi default (data value kosong), form dNd muncul, listing tidak muncul -->
		<input type="hidden" class="id-dokumen-<?= $id; ?> <?= $check['valid']; ?>" value="<?= $check['value'];  ?>" id="input-<?= $id; ?>" name="dokumen[<?= $id; ?>]" <?= $check['disabled'];  ?> />

		<div class="tampilUploader">
			<div id="drag-and-drop-zone-<?= $id; ?>" class="dm-uploader p-3 <?= $form; ?> <?= $error; ?>">
				<h5 class="mb-2 mt-2 text-muted">Seret &amp; lepaskan berkas di sini</h5>

				<div class="btn btn-primary btn-block mb-2">
					<span>Atau klik untuk mengunggah</span>
					<input type="file" title='Klik untuk mengunggah' />
				</div>
			</div><!-- /uploader -->

			<span class="text-danger error"><?php echo form_error('dokumen[' . $id . ']'); ?></span>

			<ul class="list-unstyled d-flex flex-column col mt-2 p-2" id="files-<?= $id; ?>" style="border-radius: 5px; <?= ($check['valid'] == 'is-invalid') ? 'border:1px solid #b0272b; ' : 'border:1px solid #ddd'; ?>">
				<li class="text-muted text-center empty <?= (validation_errors()) ? (set_value('dokumen[' . $id . ']') ? 'd-none' : 'ga ada value') :  'd-none'  ?>"></li>

				<li class="<?= (($verifikasi == 0) && ($id_status == 4)) ? '' : 'd-none'; ?> error-revisi"> <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> <?= $fields['kat_keterangan_surat'] ?> perlu direvisi. Silakan unggah kembali.</span></li>
				<li class="media <?= $listing; ?>" ">

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
						$thumb  = base_url() . 'public/dist/img/pdf.png';
					}
					?>

					<div class="img-thumbnail" style="background:url(<?= ($thumb) ? base_url($thumb) : base_url() . 'public/dist/img/pdf.png'; ?>) center center no-repeat;width:100px; height:100px;margin-right:20px;background-size:180px;"></div>
					<div class="media-body mb-1">
						<p class="mb-2">
							<strong><?= ($file) ? $filename['1'] : ''; ?></strong> <span class="text-muted"></span>
						</p>
						<div class="buttonedit"> <a class='btn btn-sm btn-warning' target='_blank' href='<?= ($file) ? base_url($file['file']) : ''; ?>'><i class='fas fa-eye'></i> Lihat</a> <a href='<?= base_url('mahasiswa/surat'); ?>/hapus_file/' class='deleteUser-<?= $id; ?> btn btn-sm btn-danger <?= $change; ?>' data-id='<?= ($file) ? $file['id'] : ''; ?>'> <i class='fas fa-pencil-alt'></i> Ganti</a></div>
					</div>
				</li>
			</ul>
		</div>


		<script>
			$(document).ready(function() {
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
						extFilter: ['jpg', 'jpeg'],
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

							// When a new file is added using the file selector or the DnD area
							var template = '<li class="media" id="uploaderFile' + id + '"><div class="bg-file-<?= $id; ?>" style="background-position: center center;background-repeat: no-repeat;width:100px; height:100px;margin-right:20px;margin-bottom:20px;background-size:180px;"></div><div class="media-body mb-1"><p class="mb-2"><strong>' + file.name + '</strong> - Status: <span class="text-muted">Waiting</span></p><div class="buttonedit-<?= $id; ?>"></div></div></li>';

							$('#files-<?= $id; ?>').prepend(template);
						},
						onBeforeUpload: function(id) {
							// about tho start uploading a file
							ui_multi_update_file_status(id, 'uploading', '<img width="40px" height="" src="<?= base_url() ?>public/dist/img/spinners.gif" />');
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

							if (data.extension == '.pdf') {
								var url_bg = 'url(<?= base_url(); ?>public/dist/img/pdf.png)';
							} else {
								var url_bg = 'url(<?= base_url(); ?>' + obj.thumb + ')';
							}

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

							console.log('error');
						},
						onFileExtError: function(id, file) {
							$('#files-<?= $id; ?>').find('li.empty').html('<i class="fas fa-exclamation-triangle"></i> File tidak didukung. Hanya jpg dan jpeg.').removeClass('text-muted d-none').addClass('text-danger');
							console.log('error ext');
						},
						onFileSizeError: function(id, file) {

							$('#files-<?= $id; ?>').find('li.empty').html('<i class="fas fa-exclamation-triangle"></i> File terlalu besar. Maksimum 2MB').removeClass('text-muted d-none').addClass('text-danger');
							console.log('error size');
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
			});
		</script>

	<?php } elseif ($fields['type'] == 'textarea') {
		$check = field_value_checker($fields['required'], $field_value, $id, $verifikasi, $pengajuan_status, false);
	?>

		<textarea class="form-control <?= $check['valid']; ?>" id="input-<?= $id; ?>" name="dokumen[<?= $id; ?>]" <?= $check['disabled'];  ?>><?= $check['value'];  ?></textarea>

		<span class="text-danger"><?php echo form_error('dokumen[' . $id . ']'); ?></span>

	<?php } elseif ($fields['type'] == 'wysiwyg') {
		$check = field_value_checker($fields['required'], $field_value, $id, $verifikasi, $pengajuan_status, false); ?>

		<div class="<?= (form_error('tujuan_surat')) ? 'summernote-is-invalid' : ''; ?>">

			<textarea class="form-control <?= $check['valid']; ?> textarea-summernote" id="input-<?= $id; ?>" name="dokumen[<?= $id; ?>]" <?= $check['disabled'];  ?>><?= $check['value'];  ?></textarea>

			<span class="text-danger"><?php echo form_error('dokumen[' . $id . ']'); ?></span>

		</div>


	<?php } elseif ($fields['type'] == 'text') {
		$check = field_value_checker($fields['required'], $field_value, $id, $verifikasi, $pengajuan_status, false);
	?>

		<input type="text" class="form-control <?= $check['valid']; ?>" value="<?= (validation_errors()) ? set_value('dokumen[' . $id . ']') :  $field_value;  ?>" id="input-<?= $id; ?>" name="dokumen[<?= $id; ?>]" <?= $check['disabled'];  ?> />
		<span class="text-danger"><?php echo form_error('dokumen[' . $id . ']'); ?></span>


	<?php } elseif ($fields['type'] == 'url') {
		$check = field_value_checker($fields['required'], $field_value, $id, $verifikasi, $pengajuan_status, false);
	?>

		<input type="url" class="form-control <?= $check['valid']; ?>" value="<?= (validation_errors()) ? set_value('dokumen[' . $id . ']') :  $field_value;  ?>" id="input-<?= $id; ?>" name="dokumen[<?= $id; ?>]" <?= $check['disabled'];  ?> />
		<span class="text-danger"><?php echo form_error('dokumen[' . $id . ']'); ?></span>


	<?php } elseif ($fields['type'] == 'date') {
		$check = field_value_checker($fields['required'], $field_value, $id, $verifikasi, $pengajuan_status, false);
	?>

		<input type="date" class="form-control <?= $check['valid']; ?>" value="<?= (validation_errors()) ? set_value('dokumen[' . $id . ']') :  $field_value;  ?>" id="input-<?= $id; ?>" name="dokumen[<?= $id; ?>]" <?= $check['disabled'];  ?> />
		<span class="text-danger"><?php echo form_error('dokumen[' . $id . ']'); ?></span>


	<?php } elseif ($fields['type'] == 'date_range') {
		$check = field_value_checker($fields['required'], $field_value, $id, $verifikasi, $pengajuan_status, false);
	?>

		<input type="text" class="form-control <?= $check['valid']; ?>" value="<?= (validation_errors()) ? set_value('dokumen[' . $id . ']') :  $field_value;  ?>" <?= $check['valid']; ?>" id="input-<?= $id; ?>" name="dokumen[<?= $id; ?>]" <?= $check['disabled'];  ?> />

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
		$check = field_value_checker($fields['required'], $field_value, $id, $verifikasi, $pengajuan_status, false);
	?>
		<select class="form-control <?= $check['valid']; ?>" name="dokumen[<?= $id; ?>]" id="input-<?= $id; ?>" <?= $check['disabled'];  ?>>
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

	<?php } elseif ($fields['type'] == 'sem') { //Semester
		$check = field_value_checker($fields['required'], $field_value, $id, $verifikasi, $pengajuan_status, false);
	?>
		<select class="form-control <?= $check['valid']; ?>" name="dokumen[<?= $id; ?>]" id="input-<?= $id; ?>" <?= $check['disabled'];  ?>>
			<option value=""> -- Pilih Semester -- </option>
			<?php
			$cur_year = date("Y");
			$cur_semester = (date("n") <= 6) ?  "Genap" : "Ganjil";
			?>
			<option value="Ganjil" <?= (validation_errors()) ? set_select('dokumen[' . $id . ']', "Ganjil") : ""; ?><?= ($field_value == "Ganjil") ? "selected" : ""; ?>>Ganjil</option>
			<option value="Genap" <?= (validation_errors()) ? set_select('dokumen[' . $id . ']', "Genap") : ""; ?> <?= ($field_value == "Genap") ? "selected" : ""; ?>>Genap</option>
		</select>
		<span class="text-danger"><?php echo form_error('dokumen[' . $id . ']'); ?></span>

		<!--  Piih Mahasiswa -->
	<?php } elseif ($fields['type'] == 'select_mahasiswa') { //mahasiswa
		$check = field_value_checker($fields['required'], $field_value, $id, $verifikasi, $pengajuan_status, false);
	?>
		<select class="<?= $fields['key']; ?> form-control <?= $check['valid']; ?>" id="input-<?= $id; ?>" name="dokumen[<?= $id; ?>]" <?= $check['disabled'];  ?>>
			<option value="<?= ($field_value) ? $field_value : ''; ?>"><?= ($field_value) ? getUserMhsbyId($field_value)['FULLNAME'] : ''; ?></option>
		</select>

		<script>
			$(document).ready(function() {
				$('.<?= $fields['key']; ?>').select2({
					ajax: {
						url: '<?= base_url('mahasiswa/surat/getmahasiswa'); ?>',
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
					placeholder: '<?= $fields['placeholder']; ?>',
					minimumInputLength: 3,
					// templateResult: formatRepo,
					// templateSelection: formatRepoSelection
				});
			});
		</script>


		<span class="text-danger"><?php echo form_error('dokumen[' . $id . ']'); ?></span>

		<!--  Piih Pembimbing -->
	<?php } elseif ($fields['type'] == 'select_dosen') { //dosen
		$check = field_value_checker($fields['required'], $field_value, $id, $verifikasi, $pengajuan_status, false);
	?>

		<select class="<?= $fields['key']; ?> form-control <?= $check['valid']; ?>" id="input-<?= $id; ?>" name="dokumen[<?= $id; ?>]" <?= $check['disabled'];  ?>>
			<option value="<?= ($field_value) ? $field_value : ''; ?>"><?= ($field_value) ? getDosenbyId($field_value)['nama'] : ''; ?></option>
		</select>

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
					placeholder: '<?= $fields['placeholder']; ?>',
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


	<?php
}

function menu_edit_verifikasi($id, $id_surat, $id_status, $verifikasi, $id_kategori_surat, $editable) {
	
	$CI = &get_instance();

	if ((($id_status == 2 && $verifikasi == 0) || ($id_status == 3 && $verifikasi == 0) || ($id_status == 5 && $verifikasi == 0) || ($id_status == 8 && $verifikasi == 0))
	&& (($CI->session->userdata('role') == 2) || ($CI->session->userdata('role') == 1))
) {		

	if ($CI->session->userdata('role') == 1 ) { 						
		
		if($id_kategori_surat == '6') {
			if($editable === true) {
				edit_field($id,  $id_surat);
			}
			data_sesuai($id, $verifikasi, '');
		}		

	} else  {		

		if($id_kategori_surat !== '6') {
			if($editable === true) {
				edit_field($id,  $id_surat);
			}
			data_sesuai($id, $verifikasi, '');
		}		
	}			
}
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
	$id_kategori_surat = ($fields) ? $fields['id_kategori_surat'] : '0';


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
			$thumb = '';
		}

	?>

		<div class="media mb-2 p-2 bg-perak" style="border-radius:4px; <?= (($verifikasi == 0) && ($id_status == 4)) ? 'border:1px solid #b0272b; ' : 'border:1px solid #ddd'; ?>">
			<div class="img-thumbnail" style="background:url(<?= ($thumb) ? base_url($thumb) : base_url() . 'public/dist/img/pdf.png'; ?>) center center no-repeat;width:100px; height:100px;margin-right:20px;background-size:180px;"></div>
			<div class="media-body p-2 mb-2">
				<p><strong><?= isset($file_name) ? $file_name : ''; ?></strong></p>
				<a class='btn btn-sm btn-warning' target='_blank' href='<?= base_url($image); ?>'><i class='fas fa-eye'></i> Lihat</a>

			</div>
		</div>
		<?php menu_edit_verifikasi($id, $id_surat, $id_status, $verifikasi, $id_kategori_surat, false);
		
	} elseif ($fields['type'] == 'image') {

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
			$thumb = '';
		}



		?>

		<div class="media mb-2 p-2 bg-perak" style="border-radius:4px; <?= (($verifikasi == 0) && ($id_status == 4)) ? 'border:1px solid #b0272b; ' : 'border:1px solid #ddd'; ?>">
			<div class="img-thumbnail" style="background:url(<?= ($thumb) ? base_url($thumb) : base_url() . 'public/dist/img/pdf.png'; ?>) center center no-repeat;width:100px; height:100px;margin-right:20px;background-size:180px;"></div>
			<div class="media-body p-2 mb-2">
				<p><strong><?= isset($file_name) ? $file_name : ''; ?></strong></p>
				<a class='btn btn-sm btn-warning' target='_blank' href='<?= base_url($image); ?>'><i class='fas fa-eye'></i> Lihat</a>

			</div>
		</div>
		<?php 
		
		menu_edit_verifikasi($id, $id_surat, $id_status, $verifikasi, $id_kategori_surat, false);

	} elseif ($fields['type'] == 'textarea') { ?>

		<textarea class="form-control mb-2 myfield" id="input-<?= $id; ?>" disabled><?= $field_value;  ?></textarea>
		<?php

		menu_edit_verifikasi($id, $id_surat, $id_status, $verifikasi, $id_kategori_surat, true);

	} elseif ($fields['type'] == 'wysiwyg') { ?>
		<textarea class="form-control mb-2 textarea-summernote myfield" id="input-<?= $id; ?>" disabled><?= $field_value;  ?></textarea>
		<div class="mt-2"></div>

		<?php
		
		menu_edit_verifikasi($id, $id_surat, $id_status, $verifikasi, $id_kategori_surat, true);

	} elseif ($fields['type'] == 'text') { ?>

		<input type="text" class="form-control mb-2" id="input-<?= $id; ?>" disabled value="<?= $field_value;  ?>" />

		<?php menu_edit_verifikasi($id, $id_surat, $id_status, $verifikasi, $id_kategori_surat, true);

	} elseif ($fields['type'] == 'number') { ?>

		<input type="number" class="form-control mb-2 myfield" id="input-<?= $id; ?>" disabled value="<?= $field_value;  ?>" />

		<?php menu_edit_verifikasi($id, $id_surat, $id_status, $verifikasi, $id_kategori_surat, true);

	} elseif ($fields['type'] == 'url') { ?>

		<input type="url" class="form-control mb-2 myfield" id="input-<?= $id; ?>" disabled value="<?= $field_value;  ?>" />

		<?php if ((($id_status == 2 && $verifikasi == 0) || ($id_status == 5 && $verifikasi == 0))
			&& (($CI->session->userdata('role') == 2) || ($CI->session->userdata('role') == 1))
		) {
			edit_field($id,  $id_surat);
			data_sesuai($id, $verifikasi, '');
		}
	} elseif ($fields['type'] == 'date') { ?>

		<input type="date" class="form-control mb-2 myfield" id="input-<?= $id; ?>" disabled value="<?= $field_value;  ?>" />

		<?php menu_edit_verifikasi($id, $id_surat, $id_status, $verifikasi, $id_kategori_surat, true);

	} elseif ($fields['type'] == 'date_range') { ?>

		<input type="text" class="form-control mb-2 myfield" id="input-<?= $id; ?>" disabled value="<?= $field_value;  ?>" />

		<?php menu_edit_verifikasi($id, $id_surat, $id_status, $verifikasi, $id_kategori_surat, true);

	} elseif ($fields['type'] == 'sem') { ?>


		<input type="text" class="form-control mb-2 myfield" id="input-<?= $id; ?>" disabled value="<?= $field_value;  ?>"></input>
		<?php menu_edit_verifikasi($id, $id_surat, $id_status, $verifikasi, $id_kategori_surat, true);

	} elseif ($fields['type'] == 'ta') { ?>

		<input type="text" class="form-control mb-2 myfield" id="input-<?= $id; ?>" disabled value="<?= $field_value;  ?>"></input>

		<?php		

			menu_edit_verifikasi($id, $id_surat, $id_status, $verifikasi, $id_kategori_surat, true);


	} elseif ($fields['type'] == 'select_dosen') {

		
		$CI = &get_instance();
		$db2 = $CI->load->database('dbsqlsrv', TRUE);

		if(strpos($field_value,',')) {
			$exp = explode(',', $field_value);

			$dosen = '';
			foreach ($exp  as $exp ) {
				$dosen .= $db2->query("SELECT nama from V_Import_Simpegawai WHERE id_pegawai ='$exp' ")->row_array()['nama'] . ", ";
			}

			$dos = $dosen;
			
		} else {
			$dos = $db2->query("SELECT nama from V_Import_Simpegawai WHERE id_pegawai ='$field_value' ")->row_array()['nama'];
		}
		

		?>

		<input type="text" class="form-control mb-2 myfield" id="input-<?= $id; ?>" disabled value="<?= $dos;  ?>"></input>

		<?php menu_edit_verifikasi($id, $id_surat, $id_status, $verifikasi, $id_kategori_surat, false);

	} elseif ($fields['type'] == 'select_mahasiswa') {

		$CI = &get_instance();
		$db2 = $CI->load->database('dbsqlsrv', TRUE);
		$mhs = $db2->query("SELECT * from V_Simpel_Pasca WHERE STUDENTID ='$field_value' ")->row_array();

		?>

		<input type="text" class="form-control mb-2 myfield" id="input-<?= $id; ?>" disabled value="<?= $mhs['FULLNAME'];  ?>"></input>

	<?php menu_edit_verifikasi($id, $id_surat, $id_status, $verifikasi, $id_kategori_surat, false);

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
	$value = $CI->db->select("kat_keterangan_surat.id, keterangan_surat.value ")
		->from('kat_keterangan_surat')
		->join('keterangan_surat', 'kat_keterangan_surat.id=keterangan_surat.id_kat_keterangan_surat', 'left')
		->where(array("key" => $key, 'id_surat' => $id_surat))
		->get()
		->row_array();
	if ($value) {
		if ($image == true) {
			$media = $CI->db->select("file")->from('media')->where(array('id' => $value['value']))->get()->row_array()['file'];
			return $media;
		} else {
			return $value['value'];
		}
	} else {
		return 0;
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
		if (($status['id_status'] == 10) || ($status['id_status'] == 12) || ($status['id_status']  == 6) || ($status['id_status']  == 20)) {
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
	-- AND ks.id != 6 
	ORDER BY id DESC");

	return $notif;
}
function tampil_notif_yudisium()
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
	WHERE  $where AND n.status = 0 	AND ks.id = 6 
	ORDER BY id DESC");

	return $notif;
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

function data_sesuai($id, $verifikasi, $admin)
{
	if ($admin != 1) {
	?>

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

	<?php
	}
}

function edit_field($id,  $id_pengajuan)
{ ?>
	<span class="d-block mb-2">
		<a href="" class="btn btn-success simpan btn-sm d-none" data-id="<?= $id; ?>" data-pengajuan="<?= $id_pengajuan; ?>"><i class="fas fa-save"></i> Simpan</a>
		<a href="" class="btn btn-warning btn-sm edit-field"><i class="fas fa-edit"></i> <span>Edit</span></a>
	</span>
<?php }

function form_verifikasi_admin($surat, $admin, $id_kategori_surat)
{
?>
	<div class="card">
		<div class="card-header">
			Hasil Verifikasi Dokumen oleh <b><?= $admin; ?></b>
		</div>
		<div class="card-body">

			<p> Setelah diperiksa dengan seksama, maka
				<?= $admin; ?> menyatakan bahwa permohonan <strong>Surat <?= $surat['kategori_surat']; ?></strong> yang diajukan oleh <strong><?= $surat['fullname']; ?></strong> : </p>

			<ul class="list-group list-group-flush">
				<li class="list-group-item"><input type="radio" name="rev2" id="diterima" value="<?= ($id_kategori_surat === '6') ? '12' : '7'; ?>" /> Diterima dan dapat diproses lebih lanjut
				</li>

				<li class="list-group-item"><input type="radio" name="rev2" id="ditolak" value="6" /> Ditolak

					<?php if ($surat['id_status'] == 2 || $surat['id_status'] == 3) { ?>
				<li class="list-group-item"><input type="radio" name="rev2" id="revisi" value="4" /> Perlu direvisi kembali
				</li>
			<?php } ?> </li>
			</ul>
			<p class="mt-4">Catatan dari Tata Usaha</p>
			<textarea class="form-control" name="catatan"></textarea>


			<p class="mt-3">
				<span class="pl-2 mb-2 d-inline-block"><input type="checkbox" name="" id="sudahPeriksa"> Pernyataan ini dibuat dengan sebenar-benarnya dan dapat dipertanggung jawabkan kebenarannya. <a class="help" data-toggle="tooltip" data-placement="top" title="Centang untuk mengaktifkan tombol verifikasi."><i class="fa fa-info-circle"></i></a></span>
			</p>


			<input type="submit" id="sub1" value="Kirim Hasil Verifikasi" name="submit" class="btn btn-<?= $surat['badge']; ?> btn-md btn-block" disabled>
		</div>


	</div>

<?php
}

function call_scripts()
{
?>

	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.1/moment.min.js"></script>
	<script type="text/javascript" src="<?= base_url() ?>/public/plugins/daterangepicker/daterangepicker.js"></script>
	<script src="<?= base_url() ?>/public/plugins/dm-uploader/dist/js/jquery.dm-uploader.min.js"></script>

	<script>
		//aktifkan fungsi edit pada field 

		$('.edit-field').on('click', function(e) {
			e.preventDefault();

			var field_id = $(this).parent().parent().find('.myfield').attr('id');
			var isDisabled = $('#' + field_id).prop('disabled');

			if (isDisabled === true) {
				$('#' + field_id).removeAttr('disabled');
				$(this).removeClass('btn-warning')
				$(this).children('i').removeClass('fa-window-close')
				$(this).children('i').addClass('fa-window-close')
				$(this).addClass('btn-danger')
				$(this).children('span').text('Batal')
				$(this).prev('a.simpan').removeClass('d-none');
				$(this).prev('a.simpan').addClass('d-inline');
			} else {
				$('#' + field_id).attr('disabled', 'true')
				$(this).removeClass('btn-danger')
				$(this).children('i').removeClass('fa-window-close')
				$(this).children('i').addClass('fa-edit')
				$(this).addClass('btn-warning')
				$(this).children('span').text('Edit')
				$(this).prev('a.simpan').removeClass('d-inline');
				$(this).prev('a.simpan').addClass('d-none');
			}

		});
		$('a.simpan').on('click', function(e) {
			tinymce.triggerSave();
			e.preventDefault();
			var href = "<?= base_url('admin/surat/editfield/'); ?>";
			var valfield = $(this).parent().parent().find('.myfield').val();
			var id = $(this).attr("data-id");
			var pengajuan_id = $(this).attr("data-pengajuan");

			$.ajax({
				url: href,
				type: "POST",
				cache: false,
				data: {
					id: id,
					valfield: valfield,
					pengajuan_id: pengajuan_id
				},
				success: function(dataResult) {

					var dataResult = JSON.parse(dataResult);

					$('[data-pengajuan="' + pengajuan_id + '"]').removeClass('d-inline')
					$('[data-pengajuan="' + pengajuan_id + '"]').addClass('d-none')
					$('[data-pengajuan="' + pengajuan_id + '"]').next('a.edit-field').removeClass('btn-danger')
					$('[data-pengajuan="' + pengajuan_id + '"]').next('a.edit-field').addClass('btn-warning')
					$('[data-pengajuan="' + pengajuan_id + '"]').next('a.edit-field').children('i').removeClass('fa-window-close')
					$('[data-pengajuan="' + pengajuan_id + '"]').next('a.edit-field').children('i').addClass('fa-edit')
					$('[data-pengajuan="' + pengajuan_id + '"]').next('a.edit-field').children('span').text('Edit')
					$('[data-pengajuan="' + pengajuan_id + '"]').parent().prev().prop('disabled', 'disabled')

				}
			});
		});
	</script>

<?php } ?>