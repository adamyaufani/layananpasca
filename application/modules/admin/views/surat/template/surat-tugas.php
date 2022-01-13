<div class="kertas">

  <p style="text-align:center;"><strong><u>SURAT TUGAS</u></strong></p>
  <p style="text-align:center;"><strong><u>NO: <?= $no_surat; ?></u></strong></p>
  <br>
  <br>
  <p>Yang bertanda tangan di bawah ini :</p>
  <div class="isi_surat">
    <table style="width: 100%;">
     
      <tr>
        <td>Nama</td>
        <td>:</td>
        <td><?= getUserbyId(getProdiById('11')['ka_prodi'])['fullname']; ?></td>
      </tr>
      <tr>
        <td>NIK/NIDN</td>
        <td>:</td>
        <td><?= getUserbyId(getProdiById('11')['ka_prodi'])['nik']; ?> / <?= getUserbyId(getProdiById('11')['ka_prodi'])['nidn']; ?> </td>
      </tr>
      <tr>
        <td>Jabatan</td>
        <td>:</td>
        <td>Direktur Pascasarjana UMY</td>
      </tr>
      <tr>
        <td>Alamat</td>
        <td>:</td>
        <td>Kampus Terpadu UMY<br>Jl. Lingkar Selatan Tamantirto, Kasihan, Bantul, Yogyakarta</td>
      </tr>
    </table>


  </div>

  <p>Memberikan tugas kepada:</p>
  <div class="isi_surat">

    <table style="width: 100%;">
      <tr>
        <td>Nama</td>
        <td>:</td>
        <td><?= getUserbyId(get_meta_value('nama_dosen', $surat['id'], false))['fullname']; ?></td>
      </tr>
      <tr>
        <td>Jabatan</td>
        <td>:</td>
        <td><?= get_meta_value('jabatan', $surat['id'], false); ?> </td>
      </tr>
    </table>

  </div>
  <div class="isi_surat">
    <?= get_meta_value('isi_surat', $surat['id'], false); ?>
  </div>

  <p style="margin-top:20px;">Yogyakarta, <?= $tanggal_surat; ?></p>

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