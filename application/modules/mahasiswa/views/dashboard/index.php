<section class="content">
  <div class="row">
    <div class="col-lg-6 col-6">
      <div class="card shadow">
        <a href="#collStatus" class="d-block card-header pt-3 pb-2 bg-danger" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collStatus">
          <p class="h5 text-center font-weight-bold text-white"> Selamat Datang </p>
        </a>
        <div class="collapse show" id="collStatus">
          <div class="card-body">
            <div class="row">
              <div class="col-2">
                <?= ($this->session->userdata('role') == 3) ? profPic($this->session->userdata('username'), 80) : ''; ?>
              </div>
              <div class="col-10">
                <h5 class=""><?= $this->session->userdata('fullname'); ?></h5>
                <span class="badge badge-success"><?= getProdibyId($this->session->userdata('id_prodi'))['prodi']; ?></span>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!--
<script>
  $("#beranda a.nav-link").addClass('active');
</script>

-->