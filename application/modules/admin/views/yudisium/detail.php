<style>
  input {
    border-radius:4px;
    border:1px solid #ccc;
  }
  input.is-invalid {
    border:1px solid #b0272b;
  }
</style>

<div class="row">
  <div class="col-lg-8 mb-4">
    <?php if (isset($msg) || validation_errors() !== '') : ?>
      <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="fa fa-exclamation"></i> Terjadi Kesalahan</h4>
        <?= validation_errors(); ?>
        <?= isset($msg) ? $msg : ''; ?>
      </div>
    <?php endif; ?>
    <!-- fash message yang muncul ketika proses penghapusan data berhasil dilakukan -->
    <?php if ($this->session->flashdata('msg') != '') : ?>
      <div class="alert alert-success flash-msg alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4>Sukses!</h4>
        <?= $this->session->flashdata('msg'); ?>
      </div>
    <?php endif; ?>


    <div class="card shadow">
      <a href="#collKeterangan" class="d-block card-header pt-3 pb-2 bg-abumuda collapsed" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collKeterangan">
        <p class="h6 font-weight-bold text-white">Data Yudisium</p>
      </a>
      <div class="collapse show" id="collKeterangan">
        <div class="card-body">

          <?php echo form_open('admin/yudisium/detail/' . $yudisium['id']);  ?>

          <div class="form-group">
            <label for="tanggal_yudisium" class="control-label">Tanggal Yudisium</label>
            <div class="">
              <input type="date" value="<?= (validation_errors()) ? set_value('tanggal_yudisium') : $yudisium['tanggal_yudisium'];  ?>" class="form-control <?= (form_error('tanggal_yudisium')) ? 'is-invalid' : ''; ?>" name="tanggal_yudisium">
              <span class="text-danger" style="font-size: 80%;"><?php echo form_error('tanggal_yudisium'); ?></span>
            </div>
          </div>

          <div class="form-group">
            <label for="ipk" class="control-label">IPK</label>
            <div class="">
              <input type="number" min="2.00" max="4.00" step="any" value="<?= (validation_errors()) ? set_value('ipk') : $yudisium['ipk'];  ?>" class="form-control <?= (form_error('ipk')) ? 'is-invalid' : ''; ?>" name="ipk" placeholder="contoh :3,6">
              <span class="text-danger" style="font-size: 80%;"><?php echo form_error('ipk'); ?></span>
            </div>
          </div>

          <div class="form-group">
            <label for="ipk" class="control-label">Lama Pendidikan</label>
            <div class="">
              <input type="number" min="1" max="4" step="1" value="<?= (validation_errors()) ? set_value('lama_tahun') : $yudisium['lama_tahun'];  ?>" name="lama_tahun" class="<?= (form_error('lama_tahun')) ? 'is-invalid' : ''; ?>"> tahun 
              <input type="number" min="1" max="12" step="1" value="<?= (validation_errors()) ? set_value('lama_bulan') : $yudisium['lama_bulan'];  ?>" name="lama_bulan" class="iss <?= (form_error('lama_bulan')) ? 'is-invalid' : ''; ?>"> bulan
              <input type="number" min="1" max="31" step="1" value="<?= (validation_errors()) ? set_value('lama_hari') : $yudisium['lama_hari'];  ?>" name="lama_hari" class="<?= (form_error('lama_hari')) ? 'is-invalid' : ''; ?>"> hari
            </div>
            <span class="text-danger" style="font-size: 80%;"><?php echo form_error('lama_tahun'); ?> 
            <?php echo form_error('lama_bulan'); ?> 
            <?php echo form_error('lama_hari'); ?></span>
          </div>

          <div class="form-group">
            <label for="ipk" class="control-label">Predikat</label>
            <div class="">
              <select class="form-control <?= (form_error('predikat')) ? 'is-invalid' : ''; ?>" name="predikat">
                <option value="">Predikat</option>
                <option value="Cumlaude" <?= ($yudisium['predikat'] == 'Cumlaude') ? 'selected="selected"' : ''; ?>>Cumlaude</option>
                <option value="Sangat Memuaskan" <?= ($yudisium['predikat'] == 'Sangat Memuaskan') ? 'selected="selected"' : ''; ?>>Sangat Memuaskan</option>
                <option value="Memuaskan" <?= ($yudisium['predikat'] == 'Memuaskan') ? 'selected="selected"' : ''; ?>>Memuaskan</option>
              </select>
              <span class="text-danger" style="font-size: 80%;"><?php echo form_error('predikat'); ?> 
            </div>
          </div>

          <div class="form-group">
            <div>
              <input type="submit" name="submit" value="Simpan" class="btn btn-info">
            </div>
          </div>

          <?php echo form_close(); ?>
        </div>
      </div>
    </div>



  </div>
  <!-- /.col -->
  <div class="col-lg-4">
    <div class="card shadow">
      <a href="#collMhs" class="d-block card-header pt-3 pb-2 bg-warning" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collMhs">
        <p class="h6 font-weight-bold text-white">Mahasiswa</p>
      </a>
      <div class="collapse show" id="collMhs">
        <div class="card-body pb-3">
          <div class="media">

            <?= profPic($yudisium['username'], 60); ?>

            <div class="media-body ml-2">
              <h5 class="mt-0 text-gray-900 mb-0 font-weight-bold"><?= $yudisium['fullname']; ?></h5>
              <span class="mb-0 badge badge-ijomuda"> <?= $yudisium['username']; ?></span>
              <p class="mb-0 text-gray-800"> <?= $yudisium['prodi']; ?></p>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
  <!-- /.col -->
</div>
<!-- /.row -->