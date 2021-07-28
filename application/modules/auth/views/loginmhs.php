<!DOCTYPE html>
<html lang="en">

<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">

	<title>SIM Layanan Pascasarjana UMY</title>

	<!-- Custom fonts for this template-->
	<link href="<?= base_url() ?>/public/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
	<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

	<!-- Custom styles for this template-->
	<link href="<?= base_url() ?>/public/dist/css/sb-admin-2.min.css" rel="stylesheet">

	<style>
	 .ahashakeheartache {
			-webkit-animation: kf_shake 0.4s 1 linear;
			-moz-animation: kf_shake 0.4s 1 linear;
			-o-animation: kf_shake 0.4s 1 linear;
		}
		@-webkit-keyframes kf_shake {
			0% { -webkit-transform: translate(30px); }
			20% { -webkit-transform: translate(-30px); }
			40% { -webkit-transform: translate(15px); }
			60% { -webkit-transform: translate(-15px); }
			80% { -webkit-transform: translate(8px); }
			100% { -webkit-transform: translate(0px); }
		}
		@-moz-keyframes kf_shake {
			0% { -moz-transform: translate(30px); }
			20% { -moz-transform: translate(-30px); }
			40% { -moz-transform: translate(15px); }
			60% { -moz-transform: translate(-15px); }
			80% { -moz-transform: translate(8px); }
			100% { -moz-transform: translate(0px); }
		}
		@-o-keyframes kf_shake {
			0% { -o-transform: translate(30px); }
			20% { -o-transform: translate(-30px); }
			40% { -o-transform: translate(15px); }
			60% { -o-transform: translate(-15px); }
			80% { -o-transform: translate(8px); }
			100% { -o-origin-transform: translate(0px); }
		}
	</style>

</head>

<body class="bg-gradient-success">

	<div class="container">

		<!-- Outer Row -->
		<div class="row justify-content-center">

			<div class="col-xl-10 col-lg-12 col-md-9">

				<div class="card o-hidden border-0 shadow-lg my-5">
					<div class="card-body p-0">
						<!-- Nested Row within Card Body -->
						<div class="row">
							<div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
							<div class="col-lg-6">
								<div class="p-5">
									<div class="text-center mb-4">
										<img src="<?= base_url('public/dist/img/logopps.png'); ?>" />
										<!-- <h1 class="h4 text-gray-900 mb-4">Login Dahulu</h1> -->

									</div>

									<?php if (isset($msg) || validation_errors() !== '') : ?>
										<div class="alert alert-danger alert-dismissible ahashakeheartache">
											<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
											
											<?= validation_errors(); ?>
											<?= isset($msg) ? $msg : ''; ?>
										</div>
									<?php endif; ?>
																

									<?php echo form_open(base_url('auth/login/' . $ref), 'class="user" '); ?>


									<div class="form-group">
										<input type="username" name="username" class="form-control form-control-user" id="username" aria-describedby="username" placeholder="<?= (!$ref) ? "Email UMY" : "Username"; ?>">
									</div>
									<div class="form-group">
										<input type="password" name="password" class="form-control form-control-user" id="password" placeholder="Password">
									</div>

									<input type="submit" name="submit" class="btn btn-danger btn-user btn-block" value="Login">

									<hr>

									<?php echo form_close(); ?>
									<hr>


								</div>
							</div>
						</div>

					</div>

				</div>
				<div class="text-center">
					<a class="small" href="<?= base_url('auth/login/non-sso'); ?>"><i class="fa fa-lock"></i></a>
				</div>
			</div>

		</div>

	</div>

	<!-- Bootstrap core JavaScript-->
	<script src="<?= base_url() ?>/public/vendor/jquery/jquery.min.js"></script>
	<script src="<?= base_url() ?>/public/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

	<!-- Core plugin JavaScript-->
	<script src="<?= base_url() ?>/public/vendor/jquery-easing/jquery.easing.min.js"></script>

	<!-- Custom scripts for all pages-->
	<script src="<?= base_url() ?>/public/js/sb-admin-2.min.js"></script>

</body>

</html>