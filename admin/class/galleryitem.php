<?php

	include_once('picture.php');
	include_once('dbconfig.php');
	
	class GalleryItem{
	
		public $itemID;
		public $itemTitle;
		public $itemDesc;
		public $itemSection;
		public $picture;
						
		function setProps($itemTitle,$itemDesc,$picture){
		
			$this->itemTitle = $itemTitle;
			$this->itemDesc = $itemDesc;			
			$this->picture = $picture;
		
		}
				
		function setID($ID){
		
			$this->itemID = $ID;
		
		}	
		
		function setSection($ID){
		
			$this->itemSection = $ID;
		
		}		
				
		function getTitle(){
		
			return $this->itemTitle;
		
		}
		
		function getDescription(){
		
			return $this->itemDesc;
		
		}
		
		function getSection(){
		
			return $this->itemSection;
		
		}
				
		function getPicture(){
		
			return $this->picture;
		
		}
		
		function saveToDB($AdminID,$GalleryID){
		
			$dbInfo = new DBConfig;		
			$con = mysqli_connect($dbInfo->getHostname(),$dbInfo->getUsername(),$dbInfo->getPassword(),$dbInfo->getDBName());
			
			//Add new Picture
			if(!isset($this->itemID)){
			
				$this->picture->saveToDB();
				$picID = $this->picture->getLastestID();
				
				$sql="INSERT into gallerypicturerecord (Name,Description,GalleryID,PictureID,AdministratorID) values ('".$this->itemTitle."','".$this->itemDesc."',".$GalleryID.",".$picID.",".$AdminID.")";					
				mysqli_query($con,$sql) or die(mysql_error());
				
			
			//Update existing Picture
			}else{			
				
					$sql="UPDATE gallerypicturerecord SET Name='".$this->itemTitle."', Description='".$this->itemDesc."', GalleryID='".$GalleryID."' WHERE gallerypicturerecordid=".$this->itemID."";
					mysqli_query($con,$sql) or die(mysql_error());
					
			}
		
		}
	
	
	}	

?>