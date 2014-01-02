<?php

	include_once('picture.php');
	include_once('dbconfig.php');

	class News{
	
		public $newsID;
		public $newsTitle;
		public $newsContent;
		public $newsPic;
		public $picPosition;
		public $width;
		public $height;
	
		function setProps($Title,$Content,$Pic,$picPosition,$width,$height){
		
			$this->newsTitle = $Title;
			$this->newsContent = $Content;
			$this->newsPic = $Pic;
			$this->picPosition = $picPosition;
			$this->width = $width;
			$this->height = $height;
		
		}	
		
		function setID($ID){
		
			$this->newsID = $ID;
		
		}
		
		function getID(){
		
			return $this->newsID;
		
		}
		
		function getTitle(){
		
			return $this->newsTitle;
		
		}
		
		function getContent(){
		
			return $this->newsContent;
		
		}
		
		function getPicture(){
		
			return $this->newsPic;
		
		}
		
		function getPicPosition(){
		
			return $this->picPosition;
		
		}
		
		function getWidth(){
		
			return $this->width;
		
		}
		
		function getHeight(){
		
			return $this->height;
		
		}
		
		function saveToDB($AdminID){
		
			$dbInfo = new DBConfig;		
			$con = mysqli_connect($dbInfo->getHostname(),$dbInfo->getUsername(),$dbInfo->getPassword(),$dbInfo->getDBName());
			
			//Add new News
			if(!isset($this->newsID)){
			
				/*$sql="INSERT into news (Title,Content,PicturePosition,Time,wasDeleted) values ('".$this->getTitle()."','".$this->getContent()."','".$featurePictureID."',".$AdminID.")";					
				echo $sql;
				
				$AttractionID = $this->getLastestID();
			
				$sql="INSERT into attractionpicturerecord (PictureType,AttractionID,PictureID,AdministratorID) values ('0','".$AttractionID."',".$featurePictureID.",".$AdminID.")";					
				echo $sql;*/
				
			
			//Update existing News
			}else{	

								
				/*$sql="UPDATE Attraction SET Title='".$this->TATitle."', Description='".$this->TAContent."', Time='".date('Y-m-d H:i:s')."' WHERE AttractionID=".$this->TAID."";
				mysqli_query($con,$sql) or die(mysql_error());*/
				
				$sql="UPDATE news SET Title='".$this->getTitle()."', Content='".$this->getContent()."', PicturePosition='".$this->getPicPosition()."', Width='".$this->getWidth()."' , Height='".$this->getHeight()."' , Time='".date('Y-m-d H:i:s')."' WHERE NewsID='".$this->getID()."'";
				mysqli_query($con,$sql) or die(mysql_error());
			
			}
		
		}
		
		function getLastestID(){
		
			$dbInfo = new DBConfig;		
			$con = mysqli_connect($dbInfo->getHostname(),$dbInfo->getUsername(),$dbInfo->getPassword(),$dbInfo->getDBName());

			$query = "SELECT * from News where wasDeleted=0";
			$result = mysqli_query($con,$query);
			$tmp;
		
			while($row = mysqli_fetch_array($result))
			{
				$tmp = $row['NewsID'];			
			}
			
			mysqli_close($con);
			
			return $tmp;		
		
		}
	
	}
	
?>