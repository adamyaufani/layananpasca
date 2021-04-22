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
            <td>: 1 Berkas</td>
          </tr>
          <tr>
            <td>Hal</td>
            <td>: <?= $pratinjau['hal']; ?></td>
          </tr>
        </table>
      </td>
      <td style="text-align:right;vertical-align:top;"> Yogyakarta, <?= $tanggal_surat; ?> </td>
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
  <p>Kami sampaikan bahwa mahasiswa dari Program Studi <?= $surat['prodi']; ?> yang bernama:</p>

  <table style="width:90%; margin-left:5%" class="nama">
    <tr>
      <td style="width:25%;">Nama</td>
      <td> : <?= $surat['fullname']; ?></td>
    </tr>
    <tr>
      <td>NIM</td>
      <td> : <?= $surat['username']; ?></td>
    </tr>
    <tr>
      <td>Program Studi</td>
      <td> : <?= $surat['prodi']; ?></td>
    </tr>
  </table>
  <br>

  <p>Bermaksud mengajukan permohonan cuti kuliah atau berhenti kuliah sementara <strong><?= get_meta_value('semester', $surat['id'], false); ?></strong> Tahun Akademik <strong><?= get_meta_value('thn_akademik', $surat['id'], false); ?></strong> dengan alasan <strong><?= get_meta_value('alasan_cuti', $surat['id'], false); ?></strong>. Berkenaan dengan hal tersebut, kami mohon untuk dapat diberikan surat cuti kepada mahasiswa tersebut diatas.</p>
  <p>Demikian surat ini kami sampaikan, atas perhatian dan kerjasamanya diucapkan terima kasih.</p>
 
  <p><em>Wassalamulaikum warahmatullaahi wabarakatuh</em></p>

  <table style="width: 100%;">
    <tr>
      <td class="ttd-dir">

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

<?php $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4-P']);
$mpdf->AddPage(); ?>

<div class="kertas">
  <h5 style="text-align: center;margin-bottom:40px;"><span style="color:#fff; background:#444444;font-size:18px;text-transform:uppercase;border:1px solid #dddddd;padding:5px 10px;">Blangko Pengajuan Cuti Kuliah</span></h5>
  
  <table style="width: 100%;">   
    <tr>
      <td colspan="2">
        <p>Kepada Yth:<br />
          <strong>Rektor<br>Cq. Kepala Biro Akademik</strong><br />
          di-<br />
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
  <p>Yang bertandatangan di bawah ini saya:</p>

  <table style="width:100%" class="nama">
    <tr>
      <td style="width:30%;">Nama</td>
      <td> : <?= $surat['fullname']; ?></td>
    </tr>
    <tr>
      <td>Nomor Mahasiswa</td>
      <td> : <?= $surat['username']; ?></td>
    </tr>
    <tr>
      <td>Program Studi</td>
      <td> : <?= $surat['prodi']; ?></td>
    </tr>
    <tr>
      <td>Tahun Akademik</td>
      <td> : <?= get_meta_value('thn_akademik', $surat['id'], false); ?></td>
    </tr>
  </table>
  <br>

  <p>Bermaksud untuk mengajukan permohonan cuti/berhenti kuliah sementara untuk semester <strong><?= get_meta_value('semester', $surat['id'], false); ?></strong> tahun akademik <strong><?= get_meta_value('thn_akademik', $surat['id'], false); ?></strong> karena : <strong><?= get_meta_value('alasan_cuti', $surat['id'], false); ?></strong>.</p>
  <p>Bersama ini saya lampirkan: </p>
  <ol>
    <li>Slip pembayaran biaya cuti kuliah</li>
    <li>Surat keterangan bebas tunggakan SPP</li>
    <li>Surat keterangan bebas pinjaman pustaka</li>
    <li>Fotokopi kartu tanda mahasiswa (KTM)</li>
  </ol>
  <p>Demikian atas perhatian dan perkenaannya kami ucapkan terima kasih.</p>
  <p><em>Wassalamulaikum warahmatullaahi wabarakatuh</em></p>

  <table style="width: 100%;">
  <tr>
    <td>&nbsp;</td>
    <td style="text-align:center;">Yogyakarta, <?= $tanggal_surat; ?></td>
  </tr>
    <tr>
      <td class="ttd-dir">

        <p>Direktur </p>
        <br />
        <br />
        <br />
        <br />
        <p>(Ir. Sri Atmaja P. Rosyidi, M.Sc.Eng., Ph.D., P.Eng.,IPM)</p>


      </td>
      <td style="text-align: center;  vertical-align:top">

        <p>Hormat saya, </p>
        <br />
        <br />
        <br />
        <br />
        <p>(<?= $surat['fullname']; ?>)</p>
      </td>
    </tr>
    <tr>
  </table>
  <br>
  <br>
  <p style="text-align:center; margin-top:30px;">
  <span style=" padding:3px 5px; border: 3px double #333;">Blangko ini segera diserahkan ke Biro Akademik untuk diterbitkan Surat Izin Cuti Kuliah</span>
  </p>
</div>