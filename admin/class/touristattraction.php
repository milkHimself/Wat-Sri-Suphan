<?php

	include_once('picture.php');
	include_once('dbconfig.php');

	class TouristAttraction{
	
		public $TAID;
		public $TATitle;
		public $TAContent;
		public $featuredPic;
		public $thumbnailPic;
		
		function setProps($Title,$Content,$featuredPic,$thumbnailPic){
			
			$this->TATitle = $Title;
			$this->TAContent = $Content;
			$this->featuredPic = $featuredPic;
			$this->thumbnailPic = $thumbnailPic;
		
		}
		
		function setID($ID){
		
			$this->TAID = $ID;
		
		}
		
		function getID(){
		
			return $this->TAID;
		
		}
		
		function getTitle(){
		
			return $this->TATitle;
		
		}
		
		function getContent(){
		
			return $this->TAContent;
		
		}
		
		function getFeaturedPic(){
		
			return $this->featuredPic;
		
		}
		
		function getThumbnailPic(){
		
			return $this->thumbnailPic;
		
		}
		
		function saveToDB($AdminID){
		
			$dbInfo = new DBConfig;		
			$con = mysqli_connect($dbInfo->getHostname(),$dbInfo->getUsername(),$dbInfo->getPassword(),$dbInfo->getDBName());
			
			//Add new Picture
			if(!isset($this->TAID)){
			
				$sql="INSERT into Attraction (Title,Description,Time,wasDeleted) values ('','".$AttractionID."',".$featurePictureID.",".$AdminID.")";					
				echo $sql;
				
				$AttractionID = $this->getLastestID();
			
				$sql="INSERT into attractionpicturerecord (PictureType,AttractionID,PictureID,AdministratorID) values ('0','".$AttractionID."',".$featurePictureID.",".$AdminID.")";					
				echo $sql;
				
			
			//Update existing Picture
			}else{			
				
				$sql="UPDATE Attraction SET Title='".$this->TATitle."', Description='".$this->TAContent."', Time='".date('Y-m-d H:i:s')."' WHERE AttractionID=".$this->TAID."";
				mysqli_query($con,$sql) or die(mysql_error());
			
			}

		
		}
		
		function getLastestID(){
		
			$dbInfo = new DBConfig;		
			$con = mysqli_connect($dbInfo->getHostname(),$dbInfo->getUsername(),$dbInfo->getPassword(),$dbInfo->getDBName());

			$query = "SELECT * from Attraction where wasDeleted=0";
			$result = mysqli_query($con,$query);
			$tmp;
		
			while($row = mysqli_fetch_array($result))
			{
				$tmp = $row['AttractionID'];			
			}
			
			mysqli_close($con);
			
			return $tmp;		
		
		}
		
		
	
	}

?>