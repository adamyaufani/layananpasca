    <style>
      table.nama {
        margin-bottom:20px;
      }
      tr.ttd-dir td {           
                     
           vertical-align: middle;
       }
      tr.ttd-dir td p {           
        text-align: center; 
       }
       tr.ttd-dir td:nth-child(1) {
           width: 70%;
           background: transparent url('<?= base_url('public/dist/img/ttd-dir.png'); ?>') center center no-repeat;
       }

      .heder {
        height: 80px;
        width: 100%;
        background: transparent url('<?= base_url('public/dist/img/logokop-pasca.jpg'); ?>') left center no-repeat;
        background-size: 400px;
        text-align: right;
        margin-bottom: 30px;
      }

      .futer {
        height: 200px;
        width: 100%;
        background: transparent url('<?= base_url('public/dist/img/footerkop-pasca.jpg'); ?>') center bottom no-repeat;
        background-size: 100%;
        text-align: right;
        padding: 40px;
      }

      .futer img {
        width: 50px;
        height: 50px;
      }
      .kertas {
        margin-bottom: 20px;
        padding:80px 150px;
        box-shadow: 1px 1px 15px #bfbfbf ;
      }
      p {
        text-align: justify;
      }
    </style>
    <div class="row">
      <div class="col-md-10 offset-md-1">
        <div class="card">
          <div class="card-header">
            <a href="<?= base_url('admin/surat/detail/' . encrypt_url($surat['id'])); ?>" class="btn btn-perak btn-md"><i class="fas fa-pencil-alt"></i> Edit</a>
            <a href="<?= base_url('admin/surat/terbitkan_surat/'. encrypt_url($surat['id'])); ?>" class="btn btn-success btn-md"><i class="fas fa-paper-plane"></i> Terbitkan Surat</a>
            
          </div>
          
            <!-- <div class="heder"></div> -->
            <div>
              <?php
              $file = FCPATH . 'application/modules/admin/views/surat/template/' . $surat['template'];
              if ($surat['template']) {
                if (file_exists($file)) {
                  include $file;
                } else {
                  echo "template tidak tersedia. Hubungi admins.";
                }
              } else {
                echo "template belum diset. Hubungi admin.";
              }
              ?>

           
            <!-- <div class="futer"></div> -->
          </div>
        </div>
      </div>
    </div>