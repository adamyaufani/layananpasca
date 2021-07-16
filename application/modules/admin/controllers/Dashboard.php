<?php defined('BASEPATH') or exit('No direct script access allowed');

require_once "vendor/autoload.php";

use PHPMailer\PHPMailer\PHPMailer;

class Dashboard extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('mailer');
		$this->load->model('dashboard_model', 'dashboard_model');		
	}

	public function index()
	{
		$data['notif'] = $this->dashboard_model->notif();
		$data['juml_surat'] = $this->dashboard_model->for_graph(10);
		$data['title'] = 'Dashboard';
		$data['view'] = 'dashboard/index';
		$this->load->view('layout/layout', $data);
	}


	public function sendmails() {
		echo "kirim email";

		$mail = new PHPMailer(true); //Argument true in constructor enables exceptions

    $mail->From = 'admin@mcvupdate.com';
    $mail->FromName = 'adam';
    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'admin@mcvupdate.com';                     // SMTP username
    $mail->Password   = 'rumahsakit';
    // $mail->Password   = decrypt_url($this->get_settings('password_email'));
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

    $mail->setFrom('admin@mcvupdate.com', 'Adam');
    $mail->isHTML(true);

		$mail->addAddress('yaufani@gmail.com');

		$mail->Subject = "hellow";
		$mail->Body = "ini body email";

		$mail->send();

		$mail->ClearAddresses();


	}

}
