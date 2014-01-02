<?php

	include_once('dbconfig.php');
	include("phpmailer/class.phpmailer.php");

	class EmailSubscription{
	
		public $SMTPHost = 'smtp.gmail.com';
		public $SMTPPort = '465';
		public $Username = 'srisuphan.temple@gmail.com';
		public $Password = 'camt2013';
		public $Title;
		public $Content;
		public $subscriptionList;
		
		function getSubscriptionList(){
		
			$dbInfo = new DBConfig;
	
			$con = mysqli_connect($dbInfo->getHostname(),$dbInfo->getUsername(),$dbInfo->getPassword(),$dbInfo->getDBName());
			$query = "SELECT * from Subscription where wasDeleted = 0";
			$result = mysqli_query($con,$query);
			$this->subscriptionList;
		
			while($row = mysqli_fetch_array($result))
			{
				$this->subscriptionList['ID'][] = $row['SubscriptionID'];
				$this->subscriptionList['Email'][] = $row['Email'];
				$this->subscriptionList['wasDeleted'][] = $row['wasDeleted'];
				$this->subscriptionList['AdminID'][] = $row['AdministratorID'];
			}
		
			mysqli_close($con);
		
			return $this->subscriptionList;
		
		}
		
		function removeSubscriptionByID($ID,$AdminID){
		
			$dbInfo = new DBConfig;		
			$con = mysqli_connect($dbInfo->getHostname(),$dbInfo->getUsername(),$dbInfo->getPassword(),$dbInfo->getDBName());

			$sql="UPDATE Subscription SET wasDeleted=1,AdministratorID='".$AdminID."' WHERE SubscriptionID=".$ID."";		
			mysqli_query($con,$sql) or die(mysql_error());
		
		}
		
		function sendToSubscriber($Title,$Content){
		
			$mail = new PHPMailer();
			$mail->IsSMTP();                                      // Set mailer to use SMTP
			$mail->Host = $this->SMTPHost;  					  // Specify main and backup server
			$mail->Port = $this->SMTPPort;
			$mail->SMTPAuth = true;                               // Enable SMTP authentication
			$mail->Username = $this->Username;                            // SMTP username
			$mail->Password = $this->Password;                           // SMTP password
			$mail->SMTPSecure = 'ssl';                            // Enable encryption, 'ssl' also accepted
			
			$mail->From = 'srisuphan.temple@gmail.com';
			$mail->FromName = 'Wat Sri Suphan';
			$mailList = array("suwichak@outlook.com","dlinerhimself@gmail.com","wolfpax@outlook.com");

			/*$mail->AddAddress('suwichak@outlook.com', '');  // Add a recipient
			$mail->AddAddress('dlinerhimself@gmail.com', '');  // Add a recipient
			$mail->AddAddress('wolfpax@outlook.com', '');  // Add a recipient*/
			//$mail->AddAddress($mailList);
			
			if(!isset($this->subscriptionList)){
			
				$this->getSubscriptionList();
			
			}
			
			for($i=0;$i<count($this->subscriptionList['Email']);$i++){

				$mail->AddAddress($this->subscriptionList['Email'][$i]);

			}
			
			$mail->AddReplyTo('', 'reply');
			//$mail->AddCC('');
			$mail->AddBCC('');

			$mail->WordWrap = 50;      
			$mail->IsHTML(true);                                  // Set email format to HTML

			$mail->Subject = $Title;
			$mail->Body    = $Content;
			
			if(!$mail->Send()){
			echo "Mailer Error: " . $mail->ErrorInfo;
			}else{
			echo "Message sent!";
			}
		
		}
	
	}
	
	/*$i = new EmailSubscription;
	$i->sendToSubscriber('Test 3','<!DOCTYPE html>
        <html lang="en-us">
            <head>
                <meta charset="utf-8">
                <title>Hi There</title>
				This is the testing content
            </head>
            <body>
    <html>');*/

?>