<div class="row">
	<div class="col-md-12">


		<div class="accordion" id="accordionExample">

			<?php


			foreach ($kategori_surat as $kategori) :

				//cek apakah karegori surat ini berhak diakses oleh user ini
				if ($kategori['prodi'] > 0) {
					$prodi_explode = explode(',', $kategori['prodi']);
					$prodinya = in_array($this->session->userdata('id_prodi'), $prodi_explode);
					if ($prodinya) {
						$hide = '';
					} else {
						$hide = 'd-none';
					}
				} else {
					$hide = '';
				} ?>
				<div class="card <?= $hide; ?>">
					<div class="card-header" id="heading-<?= $kategori['id']; ?>">
						<h2 class="h6 mb-0">
							<a href="#" data-toggle="collapse" data-target="#collapse-<?= $kategori['id']; ?>" aria-expanded="true" aria-controls="collapse-<?= $kategori['id']; ?>">
								<?= $kategori['kategori_surat']; ?>
							</a>
						</h2>
					</div>

					<div id="collapse-<?= $kategori['id']; ?>" class="collapse" aria-labelledby="heading-<?= $kategori['id']; ?>" data-parent="#accordionExample">
						<div class="card-body">
							<?= $kategori['deskripsi'];

							$cek_sudah_buat_surat = cek_sudah_buat_surat($this->session->userdata('user_id'), $kategori['id'], $kategori['min_semester']); ?>


							<a class="mb-3 btn btn-md btn-ijomuda <?php //= ($cek_sudah_buat_surat == 1) ? 'btn-ijomuda' : 'd-none'; ?>" href="<?= ($cek_sudah_buat_surat == 1) ? base_url('mahasiswa/surat/buat_surat/' . $kategori['id']) : base_url('mahasiswa/surat/buat_surat/' . $kategori['id']); ?>"><?= ($cek_sudah_buat_surat == 1) ? 'Ajukan Surat' : 'Ajukan Surat'; ?></a>
							<?php
							if ($cek_sudah_buat_surat > 1) { ?>
								<div class="alert alert-danger">
									<span><i class="fas fa-exclamation-triangle"></i> <?php if ($cek_sudah_buat_surat == 2) {
											echo "Surat yang Anda ajukan sebelumnya masih diproses. Klik <a href='" . base_url('mahasiswa/surat/') . "'>di sini </a> untuk melihat. Pastikan tidak membuat yang sama berulang kali.";
										} ?>
										<?php if ($cek_sudah_buat_surat == 3) {
											echo "syarat minimum semester (semester 2) belum terpenuhi.";
										} ?>
									</span>
								</div>

							<?php } ?>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>

	</div>
</div>