<?php

	include('dbconfig.php');

	class adminServiceImpl{	
	
		public $adminID = "";
		
		function login($Username,$Password){
		
			$dbInfo = new DBConfig;
		
			$con = mysqli_connect($dbInfo->getHostname(),$dbInfo->getUsername(),$dbInfo->getPassword(),$dbInfo->getDBName());
			$query = "select * from administrator where UserName = '".$Username."'";
			$result = mysqli_query($con,$query);
		
			while($row = mysqli_fetch_array($result))
			{
			
				if($row['PassWord'] == $Password){
					
					$this->adminID = $row['AdministratorID'];
					return "1";
				
				}
			}
		  
			mysqli_close($con);
			
		
		}
		
		function getAdminID(){
		
			return $this->adminID;
		
		}
	
	}

?>