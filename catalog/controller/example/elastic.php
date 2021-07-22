<?php
class ControllerExampleElastic extends Controller {
    public function index() {
		$mail = new PHPMailer();                              // Passing `true` enables exceptions
		try {
			//Server settings
			$mail->SMTPDebug = 2;                                 // Enable verbose debug output
			$mail->isSMTP();                                      // Set mailer to use SMTP
			$mail->Host = 'smtp.elasticemail.com';                           // Specify main and backup SMTP servers
			$mail->SMTPAuth = true;                               // Enable SMTP authentication
			$mail->Username = 'kumumufashion@gmail.com';                 // SMTP username
			$mail->Password = '463724df-de0d-4a40-b1e3-498d1b36efa7';                           // SMTP password
			$mail->SMTPSecure = '';                            // Enable TLS encryption, `ssl` also accepted
			$mail->Port = 2525;                                    // TCP port to connect to

			//Recipients
			$mail->setFrom('contact@willowbabyshop.com');
//			$mail->addAddress('weborder@willowbabyshop.com');     // Add a recipient
			$mail->addAddress('kumumufashion@gmail.com');     // Add a recipient
			//$mail->addAddress('contact@example.com');               // Name is optional
			//$mail->addReplyTo('info@example.com', 'Information');
			//$mail->addCC('cc@example.com');
			//$mail->addBCC('bcc@example.com');

			//Attachments
			//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
			//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

			//Content
			$mail->isHTML(false);                                  // Set email format to HTML
			$mail->Subject = 'Subject line goes here';
			$mail->Body    = 'test mail contact 17';
			//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
			$mail->CharSet  = 'utf-8';

			$mail->send();
			echo 'Message has been sent';
		} catch (Exception $e) {
			echo 'Message could not be sent.';
			echo 'Mailer Error: ' . $mail->ErrorInfo;
		}
    }
}