<?php 

	include_once('localeconfig.php');
	include_once('dbconfig.php');	
	include_once('galleryitem.php');
	include_once('picture.php');

	class Gallery{
	
		public $galleryID;
		public $galleryList;
				
		function addGalleryItem($AdminID,$GalleryID,$GalleryItem){
		
						
			$dbInfo = new DBConfig;
		
			$con = mysqli_connect($dbInfo->getHostname(),$dbInfo->getUsername(),$dbInfo->getPassword(),$dbInfo->getDBName());
			$result = mysqli_query($con,"SELECT * from Gallery where Gallery=".$GalleryID."");
			
			$row = mysqli_fetch_array($result);
			
			if(count($row)==0){
			
				$sql="INSERT into Gallery (Gallery,Time) values (".$GalleryID.",'".date('Y-m-d H:i:s')."')";		
				mysqli_query($con,$sql) or die(mysql_error());				
				
			}
			
			$GalleryItem->saveToDB($AdminID,$GalleryID);

			mysqli_close($con);
		
		}
		
		function getGalleryItemList(){
		
			$dbInfo = new DBConfig;
		
			$con = mysqli_connect($dbInfo->getHostname(),$dbInfo->getUsername(),$dbInfo->getPassword(),$dbInfo->getDBName());
			$result = mysqli_query($con,"SELECT * FROM gallerypicturerecord JOIN picture ON Picture.PictureID = gallerypicturerecord.PictureID where Picture.wasDeleted = 0;");
			
			while($row = mysqli_fetch_array($result))
			{
				$this->galleryList['ID'][] = $row['GalleryPictureRecordID'];
				$this->galleryList['Name'][] = $row['Name'];
				$this->galleryList['Description'][] = $row['Description'];
				$this->galleryList['Section'][] = $row['GalleryID'];
			}

			mysqli_close($con);
			
			return $this->galleryList;
		
		}
		
		function getGalleryItemListBySection($Section){
		
			$dbInfo = new DBConfig;
		
			$con = mysqli_connect($dbInfo->getHostname(),$dbInfo->getUsername(),$dbInfo->getPassword(),$dbInfo->getDBName());
			$result = mysqli_query($con,"SELECT * FROM gallerypicturerecord JOIN picture ON Picture.PictureID = gallerypicturerecord.PictureID where Picture.wasDeleted = 0 AND gallerypicturerecord.galleryid = ".$Section.";");
						
			$picture = new Picture;
			
			while($row = mysqli_fetch_array($result))
			{
				$this->galleryList['ID'][] = $row['GalleryPictureRecordID'];
				$this->galleryList['Name'][] = $row['Name'];
				$this->galleryList['Description'][] = $row['Description'];	
				$this->galleryList['PictureID'][] = ($row['PictureID']);
			}

			mysqli_close($con);
			
			return $this->galleryList;
		
		}
		
		function getGalleryItemByID($ID){
		
			$dbInfo = new DBConfig;
		
			$con = mysqli_connect($dbInfo->getHostname(),$dbInfo->getUsername(),$dbInfo->getPassword(),$dbInfo->getDBName());
			$result = mysqli_query($con,"SELECT * FROM gallerypicturerecord where GalleryPictureRecordID = ".$ID.";");
			
			$picture = new Picture;
			$galleryItem = new GalleryItem;
			
			while($row = mysqli_fetch_array($result))
			{				
				$picture->getPropsByID($row['PictureID']);
				$galleryItem->setProps($row['Name'],$row['Description'],$picture);
				$galleryItem->setSection($row['GalleryID']);
			}
			
			return $galleryItem;
		
		}
		
		function removeGalleryItemByID($ID){
				
			$dbInfo = new DBConfig;
		
			$con = mysqli_connect($dbInfo->getHostname(),$dbInfo->getUsername(),$dbInfo->getPassword(),$dbInfo->getDBName());
			$result = mysqli_query($con,"SELECT * FROM gallerypicturerecord where GalleryPictureRecordID = ".$ID.";");
			
			$picID;
			
			while($row = mysqli_fetch_array($result))
			{
				$picID = $row['PictureID'];
			}
		
			$obj = new Picture;
			$obj->removeFromDB($picID);
		
		}
		
	}
	
?>