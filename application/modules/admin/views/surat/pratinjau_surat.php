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
                    <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                        <div class="btn-group mr-3" role="group" aria-label="Basic example">
                            <button onclick="location.href='<?= base_url('admin/surat/detail/' . encrypt_url($surat['id'])); ?>'" type="button" class="btn btn-perak btn-md"><i class="fas fa-pencil-alt"></i> Edit</button>
                        </div>
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <?php echo form_open('admin/surat/disetujui'); ?>
                                <input type="hidden" name="id_surat" value="<?= $surat['id']; ?>">
                                <button class="btn btn-success btn-md" name="submit" value="submit"><i class="fas fa-file-signature"></i> Proses ACC Direktur Pasca</button>
                            <?php echo form_close(); ?>
                        </div>
                    </div>           
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