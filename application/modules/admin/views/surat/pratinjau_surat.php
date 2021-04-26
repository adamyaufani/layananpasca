   <style>     

        div.kertas {
            width: 100%;
            height:100%;
            line-height: 1.5;
            font-size: 11pt !important;
            font-family: Times, serif;
            padding:100px;
        }      

        div.kepada {
            margin: 10px 0 5px 0;
        }

        div.kepada p {
            font-weight: normal;
            padding-bottom: 0;
        }

        div.kepada ol {
            padding: 0;
            margin: 0;
            margin-left: 30px;
        }            

        div.ttd-dir {  
            margin-top:10px;          
            background: transparent url('<?= base_url('public/dist/img/ttd-dir.png'); ?>') left top no-repeat;
           
        }

        .futer {
            height: 1.5cm;
            width: 100%;
            background: transparent url('<?= base_url('public/dist/img/footerkop-pasca.jpg'); ?>') center bottom no-repeat;
            background-size: 100%;
            text-align: right;
            padding: 40px 57px 0px 55px;
        }

        .futer img {
            width: 50px;
            height: 50px;
        }     
        
        .isi_surat  table {
            width:100%;
        }  

        .isi_surat table {
            width: 100%;
            margin-left: 30px;
            margin-bottom: 5px;
        }

        .isi_surat table tr td:nth-child(1) {
            width: 25%;
        }
        .isi_surat table tr td:nth-child(2) {
            width: 10px;
        }

        .isi_surat table tr td {
            vertical-align: top;
            padding: 2px 0;
        }
        .isi_surat p {
            margin-bottom:15px;
        }

        .isi_surat p {          
            margin: 0;
            padding: 0;
            padding-bottom: 4px;
            text-align: justify;
        }
        .isi_surat p.salam {
            font-style: italic;
        }
      

        .isi_surat ol {
            margin: 0;
            padding: 5px 0 5px 30px;
            list-style:decimal;
        }

        .isi_surat ol li {
            margin-bottom: 2px;
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