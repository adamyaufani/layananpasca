
<html>

<head>
    <title><?= $surat['kategori_surat'] ?></title>
    <style>
    
        div.kertas {
            width: 100%;
            height: 100%;
        }

        table td {
            line-height: 1.2;
            font-size: 10pt;
        }

        td.ttd-dir {
            height: 2cm;
            text-align: center;
            width: 70%;
            background: url('<?= base_url('public/dist/img/ttd-dir.png'); ?>') center center no-repeat;
            vertical-align: middle;
        }
        .futer {
            height: 1.5cm;
            width: 100%;
            background: transparent url('<?= base_url('public/dist/img/footerkop-pasca.jpg'); ?>') center bottom no-repeat;
            background-size:100%;
            text-align:right;
            padding:40px;
        }
        .futer img {
            width:50px;
            height:50px;
        }
       
        table.nama {
            margin-bottom: 20px;
        }

        p {
            line-height: 1.5;
            font-size: 10pt;
            margin: 0;
            padding: 0;
            padding-bottom: 15px;
        }

        ol li {
            font-size: 10pt;
        }
    </style>
</head>

<body>
    <div style="margin:4cm 2.5cm 4cm 2.5cm;">
        <?php
        $file = FCPATH . 'application/modules/generatesurat/views/template/' . $surat['template'];
        if ($surat['template']) {
            if (file_exists($file)) {
                include $file;
            } else {
                echo "template tidak tersedia. Hubungi admin.";
            }
        } else {
            echo "template belum diset. Hubungi admin.";
        }
        ?>

    </div>

</body>

</html>