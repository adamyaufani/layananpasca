<!DOCTYPE html>
<html>
<head>
    <title><?= $surat['kategori_surat'] ?></title>
    <link href="<?= base_url('public/dist/css/reset.css'); ?>" rel="stylesheet">
    <style>
        html,
        body {
            height: 297mm;
            width: 210mm;
            line-height: 1.5;
            font-size: 11pt !important;
            font-family:'Times New Roman', Times, serif;
        }

        div.kertas {
            width: 100%;
            height:100%;
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
            background-size: 12cm;
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
        
        table {
            width:100%;
        }  

        table.nama td {
            padding-top:5px;
            padding-bottom:5px;
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
        .isi-surat p {
            margin-bottom:15px;
        }

        p {          
            margin: 0;
            padding: 0;
            padding-bottom: 4px;
            text-align: justify;
        }
        p.salam {
            font-style: italic;
        }
      

        ol {
            margin: 0;
            padding: 5px 0 5px 30px;
            list-style:decimal;
        }

        ol li {
            margin-bottom: 2px;
        }
    </style>
</head>

<body>
    <div style="margin:4cm 2.5cm 4cm 2.5cm;">
        <?php     

        $file = FCPATH . 'application/modules/admin/views/surat/template/' . $surat['template_lama'];

        if ($surat['template_lama']) {
            if (file_exists($file)) {
                include $file;
            } else {
                echo "template tidak tersedia. Hubungi admins.";
            }
        } else {
            echo "template belum diset. Hubungi admin.";
        }
        ?>

    </div>

</body>

</html>