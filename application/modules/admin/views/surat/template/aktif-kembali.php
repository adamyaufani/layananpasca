<div class="kertas">
  <table style="width: 100%;">
    <tr>
      <td width="70%">
        <table style="width: 100%;">
          <tr>
            <td width="15%">Nomor</td>
            <td>: <?= $no_surat; ?></td>
          </tr>
          <tr>
            <td width="15%">Lamp</td>
            <td>: 1 Berkas</td>
          </tr>
          <tr>
            <td>Hal</td>
            <td>: <?= $pratinjau['hal']; ?></td>
          </tr>
        </table>
      </td>
      <td style="text-align:right;vertical-align:top;">Yogyakarta, <?= $tanggal_surat; ?> </td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2">
        <p>Kepada Yth:<br />
          <strong><?= $pratinjau['instansi']; ?></strong>
          di<br />
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tempat
        </p>
      </td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
  </table>

  <p><em>Assalamualaikum warahmatullaahi wabarakatuh</em></p>
  <p>Dengan hormat,</p>
  <p>Kami sampaikan bahwa Mahasiswa dari Program Studi <?= $surat['prodi']; ?> Program Pascasarjana Universitas Muhammadiyah Yogyakarta </p>

  <table style="width:90%; margin-left:5%" class="nama">
    <tr>
      <td style="width:25%;">Nama</td>
      <td> : <?= $surat['fullname']; ?></td>
    </tr>
    <tr>
      <td>NIM</td>
      <td> : <?= $surat['username']; ?></td>
    </tr>

  </table>

  <p>Bermaksud untuk mengajukan kembali aktif perkuliahan. Bersama ini kami lampirkan dokumen persyaratan yang dibutuhkan. </p>
  <p>Demikian surat ini kami sampaikan. Atas perhatiannya kami ucapkan terima kasih.</p>
  <p><em>Wassalamualaikum warahmatullaahi wabarakatuh</em></p>


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
