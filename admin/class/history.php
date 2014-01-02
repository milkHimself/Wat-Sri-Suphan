<?php

	include_once('localeconfig.php');
	include_once('dbconfig.php');	

	class History{
	
		public $content;	
		
		function getHistoryContent(){
			
			$dbInfo = new DBConfig;
		
			$con = mysqli_connect($dbInfo->getHostname(),$dbInfo->getUsername(),$dbInfo->getPassword(),$dbInfo->getDBName());
			$result = mysqli_query($con,"SELECT * FROM History where wasDeleted = 0;");
			
			while($row = mysqli_fetch_array($result))
			{
				$this->content = $row['HistoryContent'];
			}

			mysqli_close($con);
			
			if(isset($this->content))
			{
				return $this->content;
			}else
			{
				return null;
			}
		
		}
		
		function updateHistoryContent($AdminID,$Content){
		
			$dbInfo = new DBConfig;
			$con = mysqli_connect($dbInfo->getHostname(),$dbInfo->getUsername(),$dbInfo->getPassword(),$dbInfo->getDBName());
						
			if(($this->getLastestHistoryID())!=null){			
			$id = $this->getLastestHistoryID();
			$sql="UPDATE history SET wasDeleted=1 , AdministratorID=".$AdminID." WHERE HistoryID=".$id."";			
			mysqli_query($con,$sql) or die(mysql_error());			
			}
			
			$sql="INSERT into history (HistoryContent,Time,AdministratorID,wasDeleted) values ('".$Content."','".date('Y-m-d H:i:s')."',".$AdminID.",'0')";
			mysqli_query($con,$sql) or die(mysql_error());		
		
		}
		
		function getLastestHistoryID(){
		
			$dbInfo = new DBConfig;
		
			$con = mysqli_connect($dbInfo->getHostname(),$dbInfo->getUsername(),$dbInfo->getPassword(),$dbInfo->getDBName());
			$result = mysqli_query($con,"SELECT * FROM History where wasDeleted = 0;");
			$id = '';			
			
			while($row = mysqli_fetch_array($result))
			{
				$id = $row['HistoryID'];
			}
			
			return $id;
		
		}
	
	}

?>