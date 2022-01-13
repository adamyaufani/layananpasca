<div class="kertas">
  <table style="width: 100%;">
    <tr>
      <td width="60%">
        <table style="width: 100%;">
          <tr>
            <td width="15%">Nomor</td>
            <td>: <?= $no_surat; ?></td>
          </tr>
          <tr>
            <td width="15%">Lamp</td>
            <td>: <?= ($pratinjau['lamp']) ? $pratinjau['lamp'] . ' Berkas' : '-'; ?> </td>
          </tr>
          <tr>
            <td>Hal</td>
            <td>: <?= $pratinjau['hal']; ?></td>
          </tr>
        </table>
      </td>
      <td style="text-align:right;vertical-align:top;"> Yogyakarta, <?= $tanggal_surat; ?> </td>
    </tr>    
  </table>

  <div class="kepada">
    <p>Kepada Yth:</p>
    <?= $pratinjau['instansi']; ?>
    <p>di</p>
    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tempat</p>
  </div>

  <p><em>Assalamualaikum warahmatullaahi wabarakatuh</em></p>
  <p>Dengan hormat,</p>
  <p>Kami sampaikan bahwa mahasiswa dari Program Studi <?= $surat['prodi']; ?> yang bernama:</p>

  <table style="width:90%; margin-left:5%;margin-bottom:10px;" class="nama">
    <tr>
      <td style="width:25%;">Nama</td>
      <td> : <?= $surat['fullname']; ?></td>
    </tr>
    <tr>
      <td>NIM</td>
      <td> : <?= $surat['username']; ?></td>
    </tr> 
  </table>

  <?php 
  // $tgl=  explode(' - ', get_meta_value('waktu_penelitian', $surat['id'], false));
  
  // $dateawal=date_create($tgl[0]);
  // $awal = date_format($dateawal,"j F Y");
  // $dateakhir=date_create($tgl[1]);
  // $akhir = date_format($dateakhir,"j F Y");
  // //durasi hari
  // $hari=date_diff($dateawal,$dateakhir);
  
  ?>

  <p>Bermaksud untuk melakukan penelitian <?= get_meta_value('tujuan_penelitian', $surat['id'], false); ?> dengan tema : <em> "<?= get_meta_value('keterangan', $surat['id'], false); ?>"</em>. Maka, kami mohon mahasiswa yang bersangkutan dapat diberikan ijin untuk melaksanakan penelitian di tempat yang Bapak/Ibu pimpin.</p>
 

  <p>Demikian surat ini kami sampaikan, atas perhatian dan kerjasamanya diucapkan terima kasih.</p>

  <p class="salam">Wassalamulaikum warahmatullaahi wabarakatuh</p>
  <div class="ttd-dir">
    <table>
      <tr class="ttd-dir">
        <td>
          <p>Direktur, </p>
          <br>
          <br>
          <br>
          <br>
          <br>
          <p><u><?= getUserbyId(getProdiById('11')['ka_prodi'])['fullname']; ?></u>
          <br>NIK. <?= getUserbyId(getProdiById('11')['ka_prodi'])['nik']; ?></p>
        </td>
        <td>
          &nbsp;
        </td>
      </tr>
      <tr>
    </table>
  </div>
  



</div>
