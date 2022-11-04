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

<?php echo form_open('', array('id' => 'edit_template_surat', 'class' => 'form-horizontal'));
?>

<div class="row">
  <div class="col-md-5">

    <div class="card card-success card-outline">
      <div class="card-header">Template surat <?= $kat['kategori_surat']; ?></div>
      <div class="card-body box-profile">

        <div class="form-group row">
          <label class="col-md-12">Nama Template (wajib)</label>
          <div class="col-md-12">
            <input type="text" value="<?= (validation_errors()) ? set_value('nama_template') : $template['nama_template'];  ?>" name="nama_template" class="form-control <?= (form_error('nama_template')) ? 'is-invalid' : ''; ?>" id="nama_template">

            <span class="invalid-feedback"><?php echo form_error('nama_template'); ?></span>

          </div>
        </div>

        <div class="form-group row">
          <label class="col-md-12">Isikan format template surat pada text area di samping (wajib)</label>
          <div class="col-md-12">
          <small class="form-text text-muted"> Berikut ini field yang dapat Anda gunakan pada template surat : <br>
              [nomor_surat], [tanggal], [lampiran], [hal], [kepada], [qrcode], [direktur], [nik_direktur], [nama], [nim], [prodi],
              <?php

              foreach ($fields as $field) {
                echo "[" . $field['key'] . "], ";
              }
              ?>

              <br>
              Catatan:
              <br>
              Pastikan text tidak dicopy paste langsung dari Word. Jika text berasal dari Word, maka cara mempastenya adalah dengan menekan tombol Ctrl+Shift+V.
            </small>
          </div>
        </div>

        <div class="form-group row">
          <div class="col-md-12">
            <button name="submit" value="submit" class="btn btn-perak btn-block simpan">Simpan Template</button>
          </div>
        </div>

      </div>

    </div>
  </div>

  <div class="col-md-7">

  <style>
    .tinymce-is-invalid {
      border: 1px solid red;
      border-radius:8px;
    }
  </style>

    <span class="text-danger" style="font-size: 80%;"><?php echo form_error('isi'); ?></span>

    <div class="<?= (form_error('isi')) ? 'tinymce-is-invalid' : ''; ?>">    
      <textarea name="isi" class="tinymce"><?= (validation_errors()) ? set_value('isi') : $template['isi'];  ?></textarea>
    </div>

    
  </div>

</div>

<?php echo form_close(); ?>