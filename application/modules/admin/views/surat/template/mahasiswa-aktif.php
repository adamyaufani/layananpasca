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
    <p>di-</p>
    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tempat</p>
  </div>

  <p class="salam">Assalamualaikum warahmatullaahi wabarakatuh</p>
  <p>Dengan hormat,</p>
  <div class="isi_surat">    
    <p>Kami sampaikan bahwa mahasiswa yang bernama:</p>
    
    <table>
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
    </table>

    <p>Saat ini merupakan mahasiswa dengan status <b>Aktif</b> di Program Studi <?= $surat['prodi']; ?> Program Pascasarjana Universitas Muhammadiyah Yogyakarta.</p>
    <p>Demikian surat ini kami sampaikan, atas perhatian dan kerjasamanya diucapkan terima kasih.</p>

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
          <p><u>Ir. Sri Atmaja P. Rosyidi, M.Sc.Eng., Ph.D., P.Eng.,IPM</u><br>NIK. 19780415200004123046</p>
        </td>
        <td>
          &nbsp;
        </td>
      </tr>
      <tr>
    </table>
  </div>
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
