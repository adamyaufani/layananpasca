<html>

<head>
    <title><?= $surat['kategori_surat'] ?></title>
    <link href="<?= base_url('public/dist/css/reset.css'); ?>" rel="stylesheet">
    <style>
        html,
        body {
            height: 297mm;
            width: 210mm;   
            padding:0;
            margin:0;     
        }
      
        .futer {
            height: 3.6cm;
            width: 100%;
            background: transparent url('<?= base_url('public/dist/img/kop-pasca-umy.png'); ?>') center bottom no-repeat;
            background-size: 100%;
            text-align: right;
            padding: 44px 57px 0px 46px;
        }

        .futer p {
            margin-top:3cm;
            font-size: 7pt;
            font-style: italic;
            text-align: left;
        }
    </style>
</head>

<body>
    <div style="margin:4cm 2.5cm 4cm 2.5cm;">

    <?php
              $file = FCPATH . 'application/modules/admin/views/surat/template-surat.php';
              include $file;               
              ?>     

    </div>

</body>

</html>