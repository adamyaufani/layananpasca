  <script type="text/javascript" src="<?= base_url() ?>/public/plugins/daterangepicker/daterangepicker.js"></script>	
	<script src="<?= base_url() ?>/public/vendor/ckeditor5/build/ckeditor.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/r/dt/jq-2.1.4,jszip-2.5.0,pdfmake-0.1.18,dt-1.10.9,af-2.0.0,b-1.0.3,b-colvis-1.0.3,b-html5-1.0.3,b-print-1.0.3,se-1.0.1/datatables.min.js"></script>
	<script src="<?= base_url() ?>/public/plugins/dm-uploader/dist/js/jquery.dm-uploader.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

  $(document).ready(function() {
			$('#datatable').DataTable();
		});

		var table = $('#datatable').DataTable();
		$('#selectload').on('change', function() {
			table.columns(2).search(this.value).draw();
		});

		var table = $('#kategorisurat').DataTable();
		$('#selectpengguna').on('change', function() {
			table.columns(1).search(this.value).draw();
		});


		$(document).ready(function() {
			$('#datatable-desc').DataTable({
				"order": [
					[1, "desc"]
				]
			});
		});

		$(document).ready(function() {
			$('#surat-desc').DataTable({
				"order": [
					[3, "desc"]
				]
			});
		});

    <script>
		document.querySelectorAll('.textarea-summernote').forEach(function(val) {
			ClassicEditor
				.create(val, {
					toolbar: {
						items: [
							'bold',
							'italic',
							'underline',
							'|',
							'heading',
							'|',
							'indent',
							'outdent',
							'alignment',
							'|',
							'numberedList',
							'bulletedList',
							'|',
							'insertTable',
							'|',
							'undo',
							'redo',
							'|',
							'code'
						]
					},
					language: 'id',
					table: {
						contentToolbar: [
							'tableColumn',
							'tableRow',
							'mergeTableCells'
						]
					},
					licenseKey: '',
				})
				.catch(error => {
					console.log(error);
				});
		});
	</script>