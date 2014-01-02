<?php

include_once('dbconfig.php');

class Picture{

	public $picID;
	public $picType;
	public $picSize;
	public $picture;	
	public $Time;
	
	function getPropsByID($picID){
		
		$this->picID = $picID;
		
		$dbInfo = new DBConfig;
		
		$con = mysqli_connect($dbInfo->getHostname(),$dbInfo->getUsername(),$dbInfo->getPassword(),$dbInfo->getDBName());
		$result = mysqli_query($con,"SELECT * from Picture where PictureID =".$picID);
		
		while($row = mysqli_fetch_array($result))
		{
			$this->picType = $row['PictureFormat'];
			$this->picSize = $row['PictureSize'];
			$this->picture = $row['Picture'];
			$this->Time = $row['Time'];
		}
		
		mysqli_close($con);
		
	}
	
	function setProps($pictype,$picsize,$picture){
	
		$this->picType = $pictype;
		$this->picSize = $picsize;
		$this->picture = $picture;
		
	}
	
	function getID(){
	
		return $this->picID;
	
	}
	
	function getType(){
	
		return $this->picType;
	
	}
	
	function getSize(){
	
		return $this->picSize;
	
	}
	
	function getPicture(){
	
		return $this->picture;
	
	}
	
	function showPicture(){
			
		return '<img src="data:image/jpeg;base64,' . base64_encode($this->picture) . '">';
	
	}
	
	function saveToDB(){
	
		$dbInfo = new DBConfig;		
		$con = mysqli_connect($dbInfo->getHostname(),$dbInfo->getUsername(),$dbInfo->getPassword(),$dbInfo->getDBName());
		
		//Add new Picture
		if(!isset($this->picID)){
		
			$sql="INSERT into Picture (PictureFormat,PictureSize,picture,Time) values ('".$this->picType."','".$this->picSize."','".$this->picture."','".date('Y-m-d H:i:s')."')";		
			mysqli_query($con,$sql) or die(mysql_error());
		
		//Update existing Picture
		}else{			
			
			$sql="UPDATE Picture SET PictureFormat='".$this->picType."', PictureSize='".$this->picSize."', picture='".$this->picture."', Time='".date('Y-m-d H:i:s')."' WHERE PictureID=".$this->picID."";
			mysqli_query($con,$sql) or die(mysql_error());
		
		}
		
	}
	
	function removeFromDB($picID){
	
		$dbInfo = new DBConfig;		
		$con = mysqli_connect($dbInfo->getHostname(),$dbInfo->getUsername(),$dbInfo->getPassword(),$dbInfo->getDBName());

		$sql="UPDATE Picture SET wasDeleted=1 WHERE PictureID=".$picID."";		
		mysqli_query($con,$sql) or die(mysql_error());
	
	}
	
	function getLastestID(){
	
		$dbInfo = new DBConfig;
	
		$con = mysqli_connect($dbInfo->getHostname(),$dbInfo->getUsername(),$dbInfo->getPassword(),$dbInfo->getDBName());
		$query = "SELECT * from Picture where wasDeleted=0";
		$result = mysqli_query($con,$query);
		$tmp;
		
		while($row = mysqli_fetch_array($result))
		{
			$tmp = $row['PictureID'];			
		}
		
		mysqli_close($con);
		
		return $tmp;
	
	}
	
}


?>