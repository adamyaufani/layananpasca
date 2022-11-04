<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-success sidebar sidebar-dark accordion toggled" id="accordionSidebar">

	<!-- Sidebar - Brand -->
	<a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url("admin/surat"); ?>">
		<div class="sidebar-brand-icon">
			<img src="<?= base_url() ?>public/dist/img/logo.png" width="40px" height="" />
		</div>
		<div class="sidebar-brand-text mx-3">SIMPELMA</div>
	</a>a

	<!-- Divider -->
	<hr class="sidebar-divider my-0">

	<!-- Nav Item - Dashboard -->
	<li class="nav-item" id="menu_dashboard">
		<a class="nav-link" href="<?= base_url("admin/dashboard"); ?>">
			<i class="fas fa-fw fa-tachometer-alt"></i>
			<span>Dashboard</span></a>
	</li>

	<!-- Divider -->
	<hr class="sidebar-divider d-none d-md-block">
	<div class="sidebar-heading">
		Pengajuan Surat
	</div>

	<li class="nav-item" id="semua_surat">
		<?php echo $link = (tampil_notif()->num_rows() > 0) ? $this->session->userdata('role') : ''; ?>
		<a class="nav-link" href="<?= base_url("admin/surat/index/" . $link); ?>">
			<i class="fas fa-fw fa-envelope"></i>
			<span>Pengajuan <?= (tampil_notif()->num_rows() > 0) ? '<span class="float-right badge badge-warning">' . tampil_notif()->num_rows() . '</span>' : ''; ?></span></a>
	</li>

	<?php if ($this->session->userdata('role') == 1) { ?>
		<li class="nav-item" id="semua_surat">
			<a class="nav-link" href="<?= base_url("admin/surat/internal/"); ?>">
				<i class="fas fa-fw fa-envelope"></i>
				<span>Pengajuan Saya</span></a>
		</li>
	<?php } ?>
	<hr class="sidebar-divider d-none d-md-block">
	<div class="sidebar-heading">
		Kelola Surat
	</div>

	<li class="nav-item" id="semua_surat">
		<a class="nav-link" href="<?= base_url("admin/surat/arsip"); ?>">
			<i class="fas fa-fw fa-envelope"></i>
			<span>Surat Keluar</span></a>
	</li>
	<hr class="sidebar-divider d-none d-md-block">
	<div class="sidebar-heading">
		Yudisium
	</div>

	<li class="nav-item" id="semua_surat">
		<a class="nav-link" href="<?= base_url("admin/surat/yudisium"); ?>">
			<i class="fas fa-graduation-cap"></i>
			<span>Surat Yudisium</span></a>
	</li>

	<li class="nav-item" id="semua_surat">
		<a class="nav-link" href="<?= base_url("admin/yudisium"); ?>">
			<i class="fas fa-graduation-cap"></i>
			<span>Peserta Yudisium</span></a>
	</li>
<!-- 
	<li class="nav-item" id="semua_surat">
		<a class="nav-link" href="<?= base_url("mahasiswa/surat/yudisium"); ?>">
			<i class="fas fa-graduation-cap"></i>
			<span>Tambah Data Yudisium</span></a>
	</li> -->

	<?php if ($this->session->userdata('role') == 1) { ?>

		<li class="nav-item" id="semua_surat">
			<a class="nav-link" href="<?= base_url("admin/suratmasuk"); ?>">
				<i class="fas fa-fw fa-envelope"></i>
				<span>Surat masuk</span></a>
		</li>
		<!-- Divider -->
		<hr class="sidebar-divider d-none d-md-block">
		<div class="sidebar-heading">
			Pengaturan
		</div>

		</li>
		<li class="nav-item" id="menu_pengguna">
			<a class="nav-link" href="<?= base_url("admin/pengguna"); ?>">
				<i class="fas fa-fw fa-users"></i>
				<span>Pengguna</span></span></a>
		</li>
		<li class="nav-item" id="menu_prodi">
			<a class="nav-link" href="<?= base_url("admin/prodi"); ?>">
				<i class="fas fa-fw fa-graduation-cap"></i>
				<span>Program Studi</span></span></a>
		</li>
		<li class="nav-item" id="menu_kategorisurat">
			<a class="nav-link" href="<?= base_url("admin/kategorisurat"); ?>">
				<i class="fas fa-fw fa-list"></i>
				<span>Kategori Surat</span></span></a>
		</li>
		<li class="nav-item" id="menu_templatesurat">
			<a class="nav-link" href="<?= base_url("admin/templatesurat"); ?>">
				<i class="fas fa-fw fa-newspaper"></i>
				<span>Template Surat</span></span></a>
		</li>
	<?php } // ednif role = 1
	?>

	<!-- Divider -->
	<hr class="sidebar-divider d-none d-md-block">

	<!-- Sidebar Toggler (Sidebar) -->
	<div class="text-center d-none d-md-inline">
		<button class="rounded-circle border-0" id="sidebarToggle"></button>
	</div>

</ul>
<!-- End of Sidebar -->
