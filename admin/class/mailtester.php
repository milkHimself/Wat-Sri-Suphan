<?php

require("phpmailer/class.phpmailer.php");

$mail = new PHPMailer();
$mail->IsSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.gmail.com';  					  // Specify main and backup server
$mail->Port = '465';
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'srisuphan.temple@gmail.com';                            // SMTP username
$mail->Password = 'camt2013';                           // SMTP password
$mail->SMTPSecure = 'ssl';                            // Enable encryption, 'ssl' also accepted


$mail->From = 'srisuphan.temple@gmail.com';
$mail->FromName = 'Wat Sri Suphan';
$mailList = array("suwichak@outlook.com","dlinerhimself@gmail.com","wolfpax@outlook.com");



/*$mail->AddAddress('suwichak@outlook.com', '');  // Add a recipient
$mail->AddAddress('dlinerhimself@gmail.com', '');  // Add a recipient
$mail->AddAddress('wolfpax@outlook.com', '');  // Add a recipient*/
//$mail->AddAddress($mailList);

for($i=0;$i<count($mailList);$i++){

	$mail->AddAddress($mailList[$i]);

}

$mail->AddReplyTo('', 'reply');
//$mail->AddCC('');
$mail->AddBCC('');

$mail->WordWrap = 50;      
$mail->IsHTML(true);                                  // Set email format to HTML

$mail->Subject = 'Test 2';
$mail->Body    =  "<!DOCTYPE html>
        <html lang='en-us'>
            <head>
                <meta charset='utf-8'>
                <title>Hi There</title>

            </head>
            <body>
    <html>";
if(!$mail->Send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
echo "Message sent!";
}

?>