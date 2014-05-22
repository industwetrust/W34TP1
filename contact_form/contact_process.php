<?php


include("../PHPMailer_v5.1/class.phpmailer.php");
include("../PHPMailer_v5.1/class.smtp.php");

error_reporting (E_ALL ^ E_NOTICE);

$post = (!empty($_POST)) ? true : false;

if($post)
{
include 'email_validation.php';

$name = stripslashes($_POST['name']);
$email = trim($_POST['email']);
$subject = stripslashes($_POST['subject']);
$message = stripslashes($_POST['message']);


$error = '';

// Check name

if(!$name)
{
$error .= 'Please enter your name.<br />';
}

// Check email

if(!$email)
{
$error .= 'Please enter an e-mail address.<br />';
}

if(!$subject)
{
    $subject = "Question du Contactez-nous";
}

if($email && !ValidateEmail($email))
{
$error .= 'Please enter a valid e-mail address.<br />';
}

// Check message (length)

if(!$message || strlen($message) < 10)
{
$error .= "Please enter your message. It should have at least 10 characters.<br />";
}


if(!$error)
{
    $mail             = new PHPMailer();
    $mail->IsSMTP();
    $mail->SMTPAuth   = true;                  // enable SMTP authentication
    $mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
    $mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
    $mail->Port       = 465;                   // set the SMTP port

    $mail->Username   = "csharp1374@gmail.com";  // GMAIL username
    $mail->Password   = "jaime la peinture";            // GMAIL password

    $mail->From       = $email;
    $mail->FromName   = $name;
    
    $mail->Subject    = $subject;
    $mail->AltBody    = $message; //Text Body
    $mail->WordWrap   = 50; // set word wrap
    $mail->MsgHTML($message);
    $mail->AddReplyTo($email);
    $mail->AddAddress("csharp1374@gmail.com"); //addresse d'envoi du courriel

    $mail->IsHTML(true); // send as HTML

    if(!$mail->Send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    } else {
        $cool = "OK";
    }
}

if($cool)
{
echo 'OK';
}

else
{
echo '<div class="notification_error">'.$error.'</div>';
}

}
