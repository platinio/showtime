<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

function sendmovies($movieArray)
{
  $html = '';

  foreach($movieArray as $movie)
  {
    $html .= "<div>";
    $html .= "<a href='". $movie['link'] ."'>";
    $html .= "<img src = '". $movie['img'] ."'>";
    $html .= "</a>";
    $html .= "</div>";
  }


  sendemail('platinio94@gmail.com' , 'Jr3472773' , 'bot@showtime.com' , 'Your Bot' , 'dontreply@showtime.com' , 'Your Bot' , $html);
}

function sendemail($email , $pass , $fromemail , $fromname , $replyemail , $replyname , $html)
{

  //Create a new PHPMailer instance
  $mail = new PHPMailer;
  //Tell PHPMailer to use SMTP
  $mail->isSMTP();
  //Enable SMTP debugging
  // 0 = off (for production use)
  // 1 = client messages
  // 2 = client and server messages
  $mail->SMTPDebug = 2;
  //Set the hostname of the mail server
  $mail->Host = 'smtp.gmail.com';
  // use
  // $mail->Host = gethostbyname('smtp.gmail.com');
  // if your network does not support SMTP over IPv6
  //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
  $mail->Port = 587;
  //Set the encryption system to use - ssl (deprecated) or tls
  $mail->SMTPSecure = 'tls';
  //Whether to use SMTP authentication
  $mail->SMTPAuth = true;
  //Username to use for SMTP authentication - use full email address for gmail
  $mail->Username = "platinio94@gmail.com";
  //Password to use for SMTP authentication
  $mail->Password = "Jr3472773";
  //Set who the message is to be sent from
  $mail->setFrom('bot@showtime.com', 'Your Bot');
  //Set an alternative reply-to address
  $mail->addReplyTo('dontreply@showtime.com', 'Your Bot');
  //Set who the message is to be sent to
  $mail->addAddress('platinio94@gmail.com', 'James Roman');
  //Set the subject line
  $mail->Subject = 'New movies recomendation from your bot';
  //Read an HTML message body from an external file, convert referenced images to embedded,
  //convert HTML into a basic plain-text alternative body
  $mail->msgHTML($html, __DIR__);
  //Replace the plain text body with one created manually
  $mail->AltBody = 'Dont support for html hummp?';
  //Attach an image file
  //$mail->addAttachment('images/phpmailer_mini.png');
  //send the message, check for errors
  if (!$mail->send())
  {
      echo "Mailer Error: " . $mail->ErrorInfo;
  } else
  {

  }

}

 ?>
