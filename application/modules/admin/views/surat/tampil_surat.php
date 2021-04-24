
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
        div.kepada  {
            margin:20px 0 20px 0;
        }
        div.kepada p  {
            line-height: 1.2rem ; 
            font-size: 10pt; 
            font-weight:normal;    
        }

        div.kepada ol  {
            padding:0;
            margin:0;  
            margin-left:30px;
            font-size:10pt; 
        }

        tr.ttd-dir td {
           
            text-align: center;           
            vertical-align: middle;
        }
        tr.ttd-dir td:nth-child(1) {
            width: 70%;
            background: transparent url('<?= base_url('public/dist/img/ttd-dir.png'); ?>') center top no-repeat;
            background-size: 100%;
        }
        .futer {
            height: 1.5cm;
            width: 100%;
            background: transparent url('<?= base_url('public/dist/img/footerkop-pasca.jpg'); ?>') center bottom no-repeat;
            background-size:100%;
            text-align:right;
            padding:40px 57px 0 55px;
        }
        .futer img {
            width:50px;
            height:50px;
        }
       
        table.nama {
            margin-bottom: 10px;
            width:90%; 
            margin-left:5%
        }
        .isi_surat table {
            width:100%;
            margin-left:10px;
            margin-bottom:10px;
        }
        .isi_surat table tr td:nth-child(1) {
            width:20%;
        }
        .isi_surat table tr td {            
            vertical-align: top;
            padding:3px 0;
        }

        p {
            line-height: 1.7;
            font-size: 10pt;
            margin: 0;
            padding: 0;
            padding-bottom: 10px;
            text-align: justify;
        }
        p strong span {
            font-size: 10pt !important;  
        }
        ol {
            margin: 0;
            padding:0 0 20px 30px;
        }

        ol li {
            font-size: 10pt !important;
            margin-bottom: 5px;
        }
    </style>
</head>

<body>
    <div style="margin:4cm 2.5cm 4cm 2.5cm;">
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

    </div>

</body>

</html>