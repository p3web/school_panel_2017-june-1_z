<?php
require("/home/ancestryatlas/public_html/phpmailertesting/PHPMailer_5.2.0/class.phpmailer.php");

$mail = new PHPMailer();

$mail->IsSMTP();                                      // set mailer to use SMTP
$mail->Host = "localhost";  // specify main and backup server
$mail->SMTPAuth = true;     // turn on SMTP authentication
$mail->Username = "test@ancestryatlas.com";  // SMTP username
$mail->Password = "Password456!"; // SMTP password

$mail->From = "test@ancestryatlas.com";
$mail->FromName = "Sukh PHP mailer testing";


//to whom you want to send an email
$mail->AddAddress("sukhjinder_singh009@yahoo.com");                  // name is optional
//sending copy of this email to on this email
$mail->AddBCC("test@ancestryatlas.com");

$mail->WordWrap = 50;                                 // set word wrap to 50 characters
$mail->IsHTML(true);                                  // set email format to HTML
//image attachment
$mail->AddEmbeddedImage('face.jpg', 'faceimg');


$mail->Subject = "Here is the subject";
$mail->Body    = "This is the HTML message body <b>in bold!</b><br> <img src=\"cid:faceimg\" />";
$mail->AltBody = "This is the body in plain text for non-HTML mail clients";

if(!$mail->Send())
{
   echo "Message could not be sent. <p>";
   echo "Mailer Error: " . $mail->ErrorInfo;
   exit;
}

echo "Message has been sent";
?>