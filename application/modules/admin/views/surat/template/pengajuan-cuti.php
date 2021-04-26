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
    <p>Kami sampaikan bahwa mahasiswa dari Program Studi <?= $surat['prodi']; ?> yang bernama:</p>
    
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

    <p>Bermaksud mengajukan permohonan cuti kuliah atau berhenti kuliah sementara pada semester <strong><?= get_meta_value('semester', $surat['id'], false); ?></strong> Tahun Akademik <strong><?= get_meta_value('thn_akademik', $surat['id'], false); ?></strong> dengan alasan <strong><?= get_meta_value('alasan_cuti', $surat['id'], false); ?></strong>. Berkenaan dengan hal tersebut, kami mohon untuk dapat diberikan surat cuti kepada mahasiswa tersebut diatas.</p>
    <p>Adapun kelengkapan dokumen yg diperlukan akan diupayakan oleh mahasiswa yang bersangkutan.</p>
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

<?php $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4-P']);
$mpdf->AddPage(); ?>

<div class="kertas">
  <h5 style="text-align: center;margin-bottom:20px;margin-top:50px;"><span style="color:#fff; background:#333333;font-size:14px;text-transform:uppercase;border:1px solid #dddddd;padding:5px 10px; display:inline-block;">Blangko Pengajuan Cuti Kuliah</span></h5>

  <div class="kepada">
    <p>Kepada Yth:</p>
    <p>Rektor</p>
    <p>Cq. Kepala Biro Akademik</p>
    <p>di</p>
    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tempat</p>
  </div>

  <p class="salam">Assalamualaikum warahmatullaahi wabarakatuh</p>
  <p>Dengan hormat,</p>
  <div class="isi_surat">
    <p>Yang bertandatangan di bawah ini saya:</p>

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
      <tr>
        <td>Program Studi</td>
        <td>:</td>
        <td><?= $surat['prodi']; ?></td>
      </tr>
      <tr>
        <td>Tahun Akademik</td>
        <td>:</td>
        <td><?= get_meta_value('thn_akademik', $surat['id'], false); ?></td>
      </tr>
    </table>

    <p>Bermaksud untuk mengajukan permohonan cuti/berhenti kuliah sementara untuk semester <strong><?= get_meta_value('semester', $surat['id'], false); ?></strong> tahun akademik <strong><?= get_meta_value('thn_akademik', $surat['id'], false); ?></strong> karena : <strong><?= get_meta_value('alasan_cuti', $surat['id'], false); ?></strong>.</p>
    <p>Bersama ini saya lampirkan: </p>
    <ol>
      <li>Slip pembayaran biaya cuti kuliah</li>
      <li>Surat keterangan bebas tunggakan SPP</li>
      <li>Surat keterangan bebas pinjaman pustaka</li>
      <li>Fotokopi kartu tanda mahasiswa (KTM)</li>
    </ol>
    <p>Demikian atas perhatian dan perkenaannya kami ucapkan terima kasih.</p>
  </div>
  <p class="salam">Wassalamulaikum warahmatullaahi wabarakatuh</p>
  <p style="text-align:right;">Yogyakarta, <?= $tanggal_surat; ?></p>
 
  <div class="ttd-dir">
  <table>
    
    <tr>
      <td>
        <p>Direktur </p>
        <br>
        <br>
        <br>
        <br>
        <br>
        <p>(Ir. Sri Atmaja P. Rosyidi, M.Sc.Eng., Ph.D., P.Eng.,IPM)</p>
        <p>&nbsp;</p>
      </td>
      <td>
        <p style="text-align:center;">Hormat saya, </p>
        <br>
        <br>
        <br>
        <br>
        <br>
        <p style="text-align:center;">(<?= $surat['fullname']; ?>)</p>
        <p>&nbsp;</p>
      </td>
    </tr>
    <tr>
  </table>
  </div>

</div>