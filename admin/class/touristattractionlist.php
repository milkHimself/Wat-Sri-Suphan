<?php

	include_once('localeconfig.php');
	include_once('dbconfig.php');	
	include_once('touristattraction.php');
	include_once('picture.php');

	class TouristAttractionList{
	
		public $TAList;
		
		function addTouristAttraction($AdminID,$TouristAttraction){	
			
			$dbInfo = new DBConfig;		
			$con = mysqli_connect($dbInfo->getHostname(),$dbInfo->getUsername(),$dbInfo->getPassword(),$dbInfo->getDBName());
			
			$ta = $TouristAttraction;
			
			$sql="INSERT into Attraction (Title,Description,Time,wasDeleted) values ('".$ta->getTitle()."','".$ta->getContent()."','".date('Y-m-d H:i:s')."',0)";					
			mysqli_query($con,$sql) or die(mysql_error());
						
			$AttractionID = $ta->getLastestID();
			
			
			$ta->thumbnailPic->saveToDB();
			$thumbnailPictureID = $ta->thumbnailPic->getLastestID();
			
			$ta->featuredPic->saveToDB();
			$featuredPictureID = $ta->featuredPic->getLastestID();
				
			$sql="INSERT into attractionpicturerecord (PictureType,AttractionID,PictureID,AdministratorID) values (1,'".$AttractionID."',".$thumbnailPictureID.",".$AdminID.")";					
			mysqli_query($con,$sql) or die(mysql_error());
			$sql="INSERT into attractionpicturerecord (PictureType,AttractionID,PictureID,AdministratorID) values (2,'".$AttractionID."',".$featuredPictureID.",".$AdminID.")";
			mysqli_query($con,$sql) or die(mysql_error());
			
			
		
		}
		
		function getTouristAttractionList(){
		
			$dbInfo = new DBConfig;
		
			$con = mysqli_connect($dbInfo->getHostname(),$dbInfo->getUsername(),$dbInfo->getPassword(),$dbInfo->getDBName());
			$result = mysqli_query($con,"SELECT * FROM Attraction where wasDeleted = 0;");
			
			while($row = mysqli_fetch_array($result))
			{
				$this->TAList['ID'][] = $row['AttractionID'];
				$this->TAList['Title'][] = $row['Title'];
			}

			mysqli_close($con);
			
			return $this->TAList;
		
		}
		
		function removeTouristAttractionByID($ID){
		
			$dbInfo = new DBConfig;
		
			$con = mysqli_connect($dbInfo->getHostname(),$dbInfo->getUsername(),$dbInfo->getPassword(),$dbInfo->getDBName());
			$sql="UPDATE Attraction SET wasDeleted=1 WHERE AttractionID=".$ID."";		
			mysqli_query($con,$sql) or die(mysql_error());
		
		}
		
		function getTouristAttractionByID($ID){
		
			$dbInfo = new DBConfig;
		
			$con = mysqli_connect($dbInfo->getHostname(),$dbInfo->getUsername(),$dbInfo->getPassword(),$dbInfo->getDBName());
			$result = mysqli_query($con,"SELECT * FROM attraction JOIN attractionpicturerecord ON attraction.attractionid = attractionpicturerecord.attractionid WHERE attraction.attractionid = ".$ID.";");
			
			$fpicture = new Picture;
			$tpicture = new Picture;
			$tatitle = "";
			$tacontent = "";
			$ta = new TouristAttraction;
			
			while($row = mysqli_fetch_array($result))
			{				
				if($row['PictureType']=="2"){
					$fpicture->getPropsByID($row['PictureID']);
				}else{
					$tpicture->getPropsByID($row['PictureID']);
				}
				
				$tatitle=$row['Title'];
				$tacontent=$row['Description'];
				
			}
			
			$ta->setProps($tatitle,$tacontent,$fpicture,$tpicture);
			$ta->setID($ID);
			
			return $ta;
		
		}	
	
	}

?>