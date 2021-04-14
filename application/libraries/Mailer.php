<?php

require_once "vendor/autoload.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

class Mailer
{
  public function send_mail($email_target, $subject, $message, $attachment = false)
  {   

    $mail = new PHPMailer(true); //Argument true in constructor enables exceptions

    $mail->From = $this->get_settings('email');
    $mail->FromName = $this->get_settings('from_email');

   // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = $this->get_settings('email');                     // SMTP username
    $mail->Password   = decrypt_url($this->get_settings('password_email'));
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

    $mail->setFrom($this->get_settings('email'), $this->get_settings('from_email'));

    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body    = $message;

    if ($attachment) {
      // $mail->addAttachment($attachment['dokumen']);
      // $mail->addAttachment($attachment['presentasi']);
    }

    if (is_array($email_target)) {
      foreach ($email_target as $email) {
        $mail->addAddress($email);
      }
    } else {
      $mail->addAddress($email_target);
    }

    if(!$mail->send()) {     
      $status = 0;
    } else {
      $status = 1;
    }

    return $status;
  }

  private function get_settings($nama_setting) {

    $CI = &get_instance();
    return $settings = $CI->db->select('value_setting')->from('settings')->where(['nama_setting'=>$nama_setting])->get()->row_array()['value_setting'];

  }
}
