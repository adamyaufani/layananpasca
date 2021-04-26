<!-- Topbar -->
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

  <!-- Sidebar Toggle (Topbar) -->
  <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
    <i class="fa fa-bars"></i>
  </button>

  <h1 class="h4 ml-2 mb-0 text-gray-800"><?= (isset($title)) ? $title : ''; ?></h1>

  <!-- Topbar Navbar -->
  <ul class="navbar-nav ml-auto">   

    <!-- Nav Item - Alerts -->
	<li class="nav-item dropdown no-arrow mx-1">
		<a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			<i class="fas fa-bell fa-fw"></i>
			<!-- Counter - Alerts -->
			<?php
			$notif_count = tampil_notif()->num_rows();
			if ($notif_count > 0) { ?>
				<span class="badge badge-danger badge-counter"><?= $notif_count; ?></span>
			<?php } ?>
		</a>
		<!-- Dropdown - Alerts -->
		<div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
			<h6 class="dropdown-header">
				Notifikasi
			</h6>

			<?php
			if ($notif_count > 0) {
				foreach (tampil_notif()->result_array() as $notif) {
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


    <div class="topbar-divider d-none d-sm-block"></div>
    <!-- Nav Item - User Information -->
    <li class="nav-item ">
      <a class="nav-link">
        <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= $this->session->userdata('fullname'); ?></span>
        <?= ($this->session->userdata('role') == 3) ? profPic($this->session->userdata('username'), 30) : ''; ?>
      </a>

    </li>
    <li class="nav-item">
      <a class="nav-link" href="#" title="Log keluar" data-toggle="modal" data-target="#logoutModal">
        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
      </a>
    </li>
  </ul>
</nav>
<!-- End of Topbar -->