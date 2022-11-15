<div class="kertas">

<p style="text-align:center;"><strong><u>SURAT KETERANGAN AKTIF KULIAH</u></strong></p>
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

  <p>Dengan ini menyatakan dengan sesungguhnya:</p>
  <div class="isi_surat">

    <table style="width: 100%;">
      <tr>
        <td>Nama</td>
        <td>:</td>
        <td><?= $surat['fullname']; ?></td>
      </tr>
      <tr>
        <td>NIM</td>
        <td>:</td>
        <td><?= $surat['username']; ?></td>
      </tr>
      <tr>
        <td>Program Studi</td>
        <td>:</td>
        <td><?= $surat['prodi']; ?></td>
      </tr>
      <tr>
        <td>Semester</td>
        <td>:</td>
        <td><?= get_meta_value('semester_angka', $surat['id'], false); ?> </td>
      </tr>
    </table>

  </div>


   <p> Dengan ini menerangkan bahwa nama tersebut diatas benar-benar masih aktif sebagai mahasiswa Program Studi <?= $surat['prodi']; ?> Semester <?= get_meta_value('ganjil_genap', $surat['id'], false); ?> TA <?= get_meta_value('ta', $surat['id'], false); ?>. Dan surat keterangan ini dibuat sebagai syarat untuk keperluan <?= get_meta_value('keperluan_surat', $surat['id'], false); ?>.</p>

    <p>Demikian surat keterangan ini dibuat untuk dapat dipergunakan sebagaimana mestinya.</p>


  </div>
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
          <p><u><?= getUserbyId(getProdiById('11')['ka_prodi'])['fullname']; ?></u><br>NIK. <?= getUserbyId(getProdiById('11')['ka_prodi'])['nik']; ?></p>
        </td>
        <td>
          &nbsp;
        </td>
      </tr>
      <tr>
    </table>
  </div>
  <br>
  <br>
  <?php if ($pratinjau['tembusan']) {
    $explode = explode(',', $pratinjau['tembusan']);
    echo "<p>Tembusan Yth:</p>";
    echo "<ol>";
    foreach ($explode as $key => $tembusan) {
      if ($tembusan) {
        echo "<li>" . $tembusan . "</li>";
      }
    }
    echo "</ol>";
  } ?>

</div>
