<style>
	.isi_surat {
		font-family: 'timesnewroman', 'Times New Roman';
		line-height: 1.2;
		font-size: 12pt !important;
	}

	table {
		width: 100%;
		font-family: 'timesnewroman', 'Times New Roman';
	}

	table tr td {
		vertical-align: top;
		padding: 2px 0;
	}

	.isi_surat p {
		margin-bottom: 0px;
	}

	ol {
		margin: 0;
		padding: 5px 0 5px 30px;
		list-style: decimal;
	}

	ol li {
		margin-bottom: 2px;
	}
</style>


<?php
//The content which should be parsed
$content = $template_surat['isi'];

//The array with all the shortcode handlers. This is just a regular associative array with anonymous functions as values. A very cool new feature in PHP, just like callbacks in JavaScript or delegates in C#.
$shortcodes = array(

	"data" => function ($isi) use ($surat, $fields, $pratinjau, $tanggal_surat) {

		if (isset($isi)) {
			$contents =  $isi;
			if ($isi == 'nama') {
				$contents = $surat['fullname'];
			} elseif ($isi == 'nim') {
				$contents = $surat['username'];
			} elseif ($isi == 'prodi') {
				$contents = $surat['prodi'];
			} elseif ($isi == 'nomor_surat') {
				$contents = $pratinjau['no_lengkap'];
			} elseif ($isi == 'tanggal') {
				$contents = $tanggal_surat;
			} elseif ($isi == 'lampiran') {
				$contents = ($pratinjau['lamp']) ? $pratinjau['lamp']  : "-";
			} elseif ($isi == 'hal') {
				$contents = $pratinjau['hal'];
			} elseif ($isi == 'kepada') {
				$contents = $pratinjau['instansi'];
			}

			$this->load->library('ciqrcode');

			$params['data'] = base_url('validasi/cekvalidasi/' . encrypt_url($surat['id']));
			$params['level'] = 'L';
			$params['size'] = 2;
			$params['savename'] = FCPATH . "public/documents/tmp/" . $surat['id'] . '-qr.png';
			$this->ciqrcode->generate($params);

			if ($isi == 'qrcode') {
				$contents = '<img src="' . base_url('public/documents/tmp/') . $surat['id'] . '-qr.png" />';
			}

			if ($isi == 'direktur') {
				getDirektur();
				$contents = getDirektur()['fullname'];
			}
			if ($isi == 'nik_direktur') {
				getDirektur();
				$contents = getDirektur()['nik'];
			}

			foreach ($fields as $field) {

				if ($isi == $field['key']) {
					$contents = get_meta_value($field['key'], $surat['id'], false);
				}
			}
		}
		return $contents;
	},


);



//http://stackoverflow.com/questions/18196159/regex-extract-variables-from-shortcode
function handleShortcodes($content, $shortcodes)
{
	//Loop through all shortcodes
	foreach ($shortcodes as $key => $function) {

		$dat = array();
		preg_match_all('/\[(.*?)\]/si', $content, $dat);

		if (count($dat) > 0  && $dat[0] != array()) {

			$i = 0;
			$actual_string = $dat[0];

			foreach ($dat[1] as $temp) {

				$temp = explode(" ", $temp);
				foreach ($temp as $d) {
					$content = str_replace($actual_string[$i], $function($d), $content);
				}

				$i++;
			}
		}
	}

	return $content;
}

?>
<div class="isi_surat">
	<?php
	echo handleShortcodes($content, $shortcodes);


	if ($pratinjau['tembusan']) {
		$pratinjau['tembusan'];
	}
	?>


</div>

<!-- </div>
</div> -->