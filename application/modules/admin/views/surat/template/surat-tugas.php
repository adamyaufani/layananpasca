<div class="kertas">

<p style="text-align:center;"><strong><u>SURAT TUGAS</u></strong></p>
<p style="text-align:center;"><strong><u>NO: <?= $no_surat; ?></u></strong></p>
<br>
<br>
<p>Yang bertanda tangan di bawah  ini :</p>

  <table style="width: 100%; margin-left:-8px;">
    <tr>
      <td width="60%">
        <table style="width: 100%;">
          <tr>
            <td width="15%">Nama</td>
            <td>: Ir.Sri Atmaja P.Rosyidi, M.Sc.Eng., Ph.D.,P.E.,IPM</td>
          </tr>
          <tr>
            <td width="15%">NIK/NIDN</td>
            <td>: 19780415200004 123 046 / 0515047801 </td>
          </tr>
          <tr>
            <td>Jabatan</td>
            <td>: Direktur Pascasarjana UMY</td>
          </tr>
          <tr>
            <td>Alamat</td>
            <td>: Kampus Terpadu UMY<br>
Jl. Lingkar Selatan Tamantirto, Kasihan, Bantul, Yogyakarta</td>
          </tr>
        </table>
      </td>
     
    </tr>    
  </table>

  <p>Memberikan tugas kepada:</p>

  <table style="width: 100%; margin-left:-8px;">
    <tr>
      <td width="60%">
        <table style="width: 100%;">
          <tr>
            <td width="15%">Nama</td>
            <td>: <?= getUserbyId(get_meta_value('dosen', $surat['id'], false))['fullname']; ?></td>
          </tr>
          <tr>
            <td width="15%">Jabatan</td>
            <td>: <?= get_meta_value('keterangan', $surat['id'], false); ?> </td>
          </tr>
          
        </table>
      </td>
     
    </tr>    
  </table>

  <div class="isi_surat">
  <?= get_meta_value('isi_surat', $surat['id'], false); ?>
  </div>
  
  <p>Yogyakarta, <?= $tanggal_surat; ?></p>

  <table style="width: 100%;">
    <tr class="ttd-dir">
      <td>
        <p>Direktur, </p>
        <br />
        <br />
        <br />
        <br />
        <p><u>Ir. Sri Atmaja P. Rosyidi, M.Sc.Eng., Ph.D., P.Eng.,IPM</u><br>NIK. 19780415200004123046</p>
      </td>
      <td style="text-align: center; height:200px; vertical-align:middle">
        &nbsp;
      </td>
    </tr>
    <tr>
  </table>

  

</div>

