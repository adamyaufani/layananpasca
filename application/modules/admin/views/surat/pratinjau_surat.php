    <style>
        .dokumen {
            background: #666666;
            padding:50px;
        }
        .kertas {
            width:21cm;
            height:auto;
            background:#ffffff;
            margin:0 auto;
            padding:3cm;
        }
    </style>
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <div class="card">
                <div class="card-header">
                    <a href="<?= base_url('admin/surat/detail/' . encrypt_url($surat['id'])); ?>" class="btn btn-perak btn-md"><i class="fas fa-pencil-alt"></i> Edit</a>
                    <a href="<?= base_url('admin/surat/terbitkan_surat/' . encrypt_url($surat['id'])); ?>" class="btn btn-success btn-md"><i class="fas fa-paper-plane"></i> Terbitkan Surat</a>
                </div>
                <div class="dokumen">
                    <div class="kertas">
                        <?php
                        $file = FCPATH . 'application/modules/admin/views/surat/template-surat.php';
                        include $file;
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>