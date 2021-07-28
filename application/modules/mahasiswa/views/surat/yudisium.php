<div class="row mt-5">
  <div class="col-md-12">
    <link rel="stylesheet" href="<?= base_url('public/vendor/jquery-ui-1.12.1/jquery-ui.min.css'); ?>">
    <!-- fash message yang muncul ketika proses penghapusan data berhasil dilakukan -->

  </div>

  <div class="col-md-8 offset-md-2">

    <?php if (isset($msg) || validation_errors() !== '') : ?>
      <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="fa fa-exclamation"></i> Terjadi Kesalahan</h4>
        <?= validation_errors(); ?>
        <?= isset($msg) ? $msg : ''; ?>
      </div>
    <?php endif; ?>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

    <div class="mt-5 card card-success card-outline shadow">

      <div class="card-body box-profile">
        <?php echo form_open('', array('id' => 'tambah_yudisium', 'class' => 'form-horizontal'));  ?>

        <div class="form-group row">
          <label for="pilih_prodi" class="col-md-2 control-label">
            <div class="media">
              <img id="fotoMhs" width="100" height="" class="mr-3" src="<?= base_url('public/dist/img/nophoto.png'); ?>" alt="Generic placeholder image">              
            </div>
          </label>
          <div class="col-md-9">
            <p>Pilih Mahasiswa</p>
            <select class="pilih_mhs form-control <?= (form_error('pilih_mhs')) ? 'is-invalid' : ''; ?> " id="pilih_mhs" name="pilih_mhs">
              <option value=""></option>
            </select>
            <span class="text-danger" style="font-size: 80%;"><?php echo form_error('pilih_mhs'); ?></span>
            <input type="submit" name="submit" value="Tambah Data Yudisium" class="mt-4 btn btn-success btn-block">
          </div>
        </div>
        
        <?php echo form_close(); ?>
      </div>
    </div>
  </div>
</div>

<script src="<?= base_url('public/vendor/jquery-ui-1.12.1/jquery-ui.min.js'); ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.js"></script>

<script type="text/javascript">
  $(document).ready(function() {

    $('.tambah-field').on('click', function() {
      var id = $(this).data('id');

      $.ajax({
        url: SITEURL + "admin/kategorisurat/tambah_field/" + id,
        success: function(res) {
          console.log(res);
          location.reload();
        },
        error: function(data) {
          console.log('Error:', data);
        }
      });
    });

  });
</script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

<script>
  $(document).ready(function() {
    $('.pilih_mhs').select2({
      ajax: {
        url: '<?= base_url('mahasiswa/surat/getmahasiswa'); ?>',
        dataType: 'json',
        type: 'post',
        delay: 250,
        data: function(params) {
          return {
            search: params.term,
          }
        },
        processResults: function(data) {
          return {
            results: data
          };
        },        
        cache: true
      },
      placeholder: 'Ketikkan nama mahasiswa',
      minimumInputLength: 3,
      // templateResult: formatRepo,
      // templateSelection: formatRepoSelection
    });

    $('.pilih_mhs').change(function(){
      var nim = $(this).val();
      var thn = nim.slice(0, 4)
      var url_img = 'https://krs.umy.ac.id/FotoMhs/' + thn + '/' + nim +'.jpg'

      console.log(url_img)

      $('#fotoMhs').prop('src', url_img);
    })
  });
</script>