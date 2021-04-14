<?php

require_once "vendor/autoload.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

class Mailer
{
  private $_CI;
  public function __construct()
  {
    $this->_CI = &get_instance();
    $this->_CI->load->model('notif/notif_model', 'notif_model');
  }
  public function send_mail($data)
  {

    //kirim notifikasi
    $this->_CI->notif_model->send_notif($data);

    $mail = new PHPMailer(true); //Argument true in constructor enables exceptions

    $mail->From = $this->get_settings('email');
    $mail->FromName = $this->get_settings('from_email');
    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = $this->get_settings('email');                     // SMTP username
    $mail->Password   = decrypt_url($this->get_settings('password_email'));
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

    $mail->setFrom($this->get_settings('email'), $this->get_settings('from_email'));
    $mail->isHTML(true);


    // if ($attachment) {
    // $mail->addAttachment($attachment['dokumen']);
    // $mail->addAttachment($attachment['presentasi']);
    // }

    $role = $data['role'];

    foreach ($role as $role) {


      if ($role != 3) {

        if ($role === 5) { //dir pasca
          $users = getUsersbyRole($role, '');
        } else {
          $users = getUsersbyRole($role, $_SESSION['id_prodi']);
        }

        foreach ($users as $user) {
          $mail->addAddress($user['email']);
        }

        $sp = $this->_CI->notif_model->get_messages($data['id_status'], $role);

        echo '<pre>';
        print_r($sp);
        echo '</pre>';

        echo $subject = $sp['judul_notif'];
        echo $body    = $sp['isi_notif'];

        $mail->Subject = $subject;
        $mail->Body = $body;

        $mail->send();

        $mail->ClearAddresses();
      } else {
        $mail->addAddress(getUserbyId($data['kepada'])['email']);

        $sp = $this->_CI->notif_model->get_messages($data['id_status'], $role);

        echo '<pre>';
        print_r($sp);
        echo '</pre>';

        echo $subject = $sp['judul_notif'];
        echo $body    = $sp['isi_notif'];

        $mail->Subject = $subject;
        $mail->Body = $body;

        $mail->send();

        $mail->ClearAddresses();
      }
    }
  }


  private function get_settings($nama_setting)
  {

    $CI = &get_instance();
    return $settings = $CI->db->select('value_setting')->from('settings')->where(['nama_setting' => $nama_setting])->get()->row_array()['value_setting'];
  }
}
