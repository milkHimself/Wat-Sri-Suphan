<?php

	include_once('dbconfig.php');

	class guestServiceImpl{
	
		function subscribe($Email){
		
			$dbInfo = new DBConfig;		
			$con = mysqli_connect($dbInfo->getHostname(),$dbInfo->getUsername(),$dbInfo->getPassword(),$dbInfo->getDBName());
		
			$sql="INSERT into Subscription (Email,wasDeleted) values ('".$Email."',0)";		
			mysqli_query($con,$sql) or die(mysql_error());
		
		}	
	
	}
	
?>