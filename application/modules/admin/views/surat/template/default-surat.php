<div class="kertas">
  <table style="width: 100%; margin-left:-8px;">
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
  <div class="isi_surat">
  <?= get_meta_value('isi_surat', $surat['id'], false); ?>
  </div>
  <p><em>Wassalamulaikum warahmatullaahi wabarakatuh</em></p>

  <table style="width: 100%;">
    <tr class="ttd-dir">
      <td>
        <p>Direktur, </p>
        <br />
        <br />
        <br />
        <br />
        <p><u><?= getUserbyId(getProdiById('11')['ka_prodi'])['fullname']; ?></u>
        <br>NIK. <?= getUserbyId(getProdiById('11')['ka_prodi'])['nik']; ?></p>
      </td>
      <td style="text-align: center; height:200px; vertical-align:middle">
        &nbsp;
      </td>
    </tr>
    <tr>
  </table>

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

