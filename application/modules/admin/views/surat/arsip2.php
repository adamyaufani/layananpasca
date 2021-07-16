


<div class="row">
	<div class="col-12">

		<div class="card card-success card-outline mb-4">
			<div class="card-body">
				<?php echo form_open("/", 'id="user_search"') ?>
				<div class="row">
					<div class="col-md-2">
						<label>Pengguna</label>
						<select name="klien" id="klien" class="form-control klien mb-2">
							<option value="<?=base_url('admin/surat/arsip'); ?>">Semua</option>
							<option value="<?=base_url('admin/surat/arsip/m'); ?>"  <?= ($klien === 'm') ? "selected" : ''; ?>>Mahasiswa</option>
							<option value="<?=base_url('admin/surat/arsip/d'); ?>" <?= ($klien === 'd') ? "selected" : ''; ?>>Dosen</option>
							<option value="<?=base_url('admin/surat/arsip/j'); ?>" <?= ($klien === 'j') ? "selected" : ''; ?>>Program Studi</option>
							<option class="<?= (($this->session->userdata('role') == 1) || ($this->session->userdata('role') == 5)) ? "" : "d-none"; ?>" value="<?=base_url('admin/surat/arsip/p'); ?>" <?= ($klien === 'p') ? "selected" : ''; ?>>Pascasarjana</option>
						</select>
						
					</div>
					<div class="col-md-4">
						<label>Kategori Surat</label>
						<select name="kategori_surat" id="kategori_surat" class="form-control">
							<option value="" class="semua">Semua kategori</option>
							<div></div>
							<?php  foreach ($kategori_surat as $option) { ?>								
								<option value="<?= $option['id']; ?>"><?= $option['kategori_surat']; ?></option>
							<?php } ?>
						</select>
					</div>
					<div class="col-md-3">
					<?php if(($klien == 'j' || $klien == 'm') && ($this->session->userdata('role') == 1 || $this->session->userdata('role') == 5)) { ?>
						<label>Pilih Program Studi</label>
						<select name="prodi" id="prodi" class="form-control prodi">
							<option value="">Semua Prodi</option>
							<?php  foreach ($prodi as $prodi) { 
								if($prodi['id'] != 11) { 
								?>
								<option value="<?= $prodi['id']; ?>"><?= $prodi['prodi']; ?></option>
							<?php } 
							}?>
						</select>
						<?php } ?>
					</div>
					<?php echo form_close(); ?>
				</div>
			</div>
		</div>
		<div class="card card-success card-outline">

			<div class="card-body">

				<table id="arsip" class="table table-striped table-bordered tb-surats">
					<thead>
						<tr>
							<th>No Surat</th>
							<th>Terbit</th>
							<th>Nama</th>
							<th>Kategori</th>
							<th>Prodi</th>
							<th>Tujuan Surat</th>
							<th>Hal</th>
							<th><i class="fas fa-file-pdf"></i></th>
						</tr>
					</thead>
				</table>

			</div><!-- /.card-body -->
		</div><!-- /.card -->
	</div>
	<!-- /.col -->
</div>
<!-- /.row -->

<script>


	$(document).ready(function() {

		$('#klien').change(function() {
			location.href = $(this).val();
		});

		//$('#klien').trigger("change");


		//---------------------------------------------------
		var table = $('#arsip').DataTable({
			"processing": true,
			"serverSide": false,
			"dom": 'Bfrtip',
			"buttons": [{
					extend: 'collection',
          text: 'Export Table',
					buttons: [
                    'copy',
                    'excel',
                   
                    'pdf',
                    'print'
					]
        }],
			"ajax": "<?= base_url('admin/surat/arsip_json/' . $klien) ?>",
			"order": [
				[2, 'desc']
			],
			"columnDefs": [{
					"targets": 0,
					"name": "id",
					'searchable': true,
					'orderable': true
				},
				{
					"targets": 1,
					"name": "no_surat",
					'searchable': true,
					'orderable': true
				},
				{
					"targets": 2,
					"name": "tanggal_terbit",
					'searchable': true,
					'orderable': true
				},
			]
		});

		// $('.pilih_tombol').click(function() {
		// 	var formData = {
		// 		'klien': $(this).attr('value')
		// 	};
		// 	$.ajax({
		// 		type: 'POST',
		// 		url: '<?php echo base_url(); ?>admin/surat/search',
		// 		data: formData,
		// 		dataType: 'json',
		// 		encode: true,
		// 		success: function(data) {
		// 			console.log(data);
		// 			table.ajax.reload();	
		// 		}
		// 	})
		// });

		//---------------------------------------------------
		$('select').on('change', function() {
			var s_form = $("#user_search").serialize();
			$.ajax({
				data: s_form,
				type: 'post',
				url: '<?php echo base_url(); ?>admin/surat/search',
				async: true,
				success: function(output) {
					table.ajax.reload();
					console.log(s_form);
				}
			});
		});



	});
</script>