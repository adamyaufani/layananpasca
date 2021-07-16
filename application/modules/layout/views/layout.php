<!DOCTYPE html>
<html lang="en">

<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Program Pascasarjana UMY">
	<meta name="author" content="Program Pascasarjana UMY">
	<meta name="robots" content="noindex, nofollow">

	<title><?= (isset($title)) ? $title : 'Sistem Pelayanan Pascasarjana UMY'; ?></title>

	<!-- Custom fonts for this template-->
	<link href="<?= base_url() ?>public/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
	<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

	<!-- Custom styles for this template-->
	<link href="<?= base_url() ?>public/dist/css/sb-admin-2.min.css" rel="stylesheet">
	<link href="<?= base_url() ?>public/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

	<link href="<?= base_url() ?>public/plugins/dm-uploader/dist/css/jquery.dm-uploader.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="<?= base_url() ?>/public/plugins/daterangepicker/daterangepicker.css" />
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/r/dt/jq-2.1.4,jszip-2.5.0,pdfmake-0.1.18,dt-1.10.9,af-2.0.0,b-1.0.3,b-colvis-1.0.3,b-html5-1.0.3,b-print-1.0.3,se-1.0.1/datatables.min.css" />
	<!-- Bootstrap core JavaScript-->
	<script src="<?= base_url() ?>public/vendor/jquery/jquery.min.js"></script>
	<script src="<?= base_url() ?>public/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

	<!-- Core plugin JavaScript-->
	<script src="<?= base_url() ?>public/vendor/jquery-easing/jquery.easing.min.js"></script>


	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.1/moment.min.js"></script>
	<script type="text/javascript" src="<?= base_url() ?>/public/plugins/daterangepicker/daterangepicker.js"></script>
	
	
	<script src="<?= base_url() ?>/public/vendor/ckeditor5/build/ckeditor.js"></script>
	
	
	<script type="text/javascript" src="https://cdn.datatables.net/r/dt/jq-2.1.4,jszip-2.5.0,pdfmake-0.1.18,dt-1.10.9,af-2.0.0,b-1.0.3,b-colvis-1.0.3,b-html5-1.0.3,b-print-1.0.3,se-1.0.1/datatables.min.js"></script>
	
<script src="<?= base_url() ?>/public/plugins/dm-uploader/dist/js/jquery.dm-uploader.min.js"></script>
</head>

<body id="page-top" class="sidebar-toggled sidenav-toggled">

	<!-- Page Wrapper -->
	<div id="wrapper">

		<?php
		if ($this->session->userdata('role') == 3) {
			include('include/mahasiswa_sidebar.php');
		} else {
			include('include/admin_sidebar.php');
		}
		?>

		<!-- Content Wrapper -->
		<div id="content-wrapper" class="d-flex flex-column">

			<!-- Main Content -->
			<div id="content">

				<?php include('include/navbar.php'); ?>

				<!-- Begin Page Content -->
				<div class="container-fluid">

					<?php $this->load->view($view); ?>

				</div>
				<!-- /.container-fluid -->

			</div>
			<!-- End of Main Content -->

			<!-- Footer -->
			<footer class="sticky-footer bg-white">
				<div class="container my-auto">
					<div class="copyright text-center my-auto">
						<span>Copyright &copy; 2021 <a href="http://pascasarjana.umy.ac.id">Program Pascasarjan UMY</a>.
							All rights reserved.</span>
					</div>
				</div>
			</footer>
			<!-- End of Footer -->

		</div>
		<!-- End of Content Wrapper -->

	</div>
	<!-- End of Page Wrapper -->

	<!-- Scroll to Top Button-->
	<a class="scroll-to-top rounded" href="#page-top">
		<i class="fas fa-angle-up"></i>
	</a>

	<!-- Logout Modal-->
	<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
					<button class="close" type="button" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
				<div class="modal-footer">
					<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
					<a class="btn btn-primary" href="<?= site_url('auth/logout'); ?>">Logout</a>
				</div>
			</div>
		</div>
	</div>

	<script type="text/javascript">
		$('#confirm-delete').on('show.bs.modal', function(e) {
			$(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
		});

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

		
	</script>

	<!-- page script -->
	<script>
		// menu sidebar
		if ($("#menu_<?= $this->router->fetch_class(); ?>").hasClass('has_child')) {
			$("#menu_<?= $this->router->fetch_class(); ?>").addClass('active');
			$("#sub_<?= $this->router->fetch_class(); ?>").addClass('show');
			$("#sub_<?= $this->router->fetch_class(); ?> div .<?= $this->router->fetch_method(); ?>").addClass('active');
		} else {
			$("#menu_<?= $this->router->fetch_class(); ?>").addClass('active');
		}

		window.setTimeout(function() {
			$(".alert-dismissible").fadeTo(500, 0).slideUp(1000, function() {
				$(this).remove();
			});
		}, 1000);
	</script>

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

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script src="<?= base_url() ?>public/dist/js/sb-admin-2.js"></script>
</body>

</html>