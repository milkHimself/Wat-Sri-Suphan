<?php 
	
	include_once('localeconfig.php');
	include_once('news.php');
	include_once('dbconfig.php');
	
	class NewsList{
	
		public $newsList;
		
		function addNews($AdminID,$News){
		
			$dbInfo = new DBConfig;		
			$con = mysqli_connect($dbInfo->getHostname(),$dbInfo->getUsername(),$dbInfo->getPassword(),$dbInfo->getDBName());
			
			$news = $News;
			
			$sql="INSERT into news (Title,Content,PicturePosition,Width,Height,Time,wasDeleted) values ('".$news->getTitle()."','".$news->getContent()."','".$news->getPicPosition()."','".$news->getWidth()."','".$news->getHeight()."','".date('Y-m-d H:i:s')."','0')";
			echo $sql;			
			mysqli_query($con,$sql) or die(mysql_error());
						
			$newsID = $news->getLastestID();		
			$news->getPicture()->saveToDB();
			$newsPicID = $news->getPicture()->getLastestID();			
			
			$sql="INSERT into newspicturerecord (NewsID,PictureID,AdministratorID) values (".$newsID.",".$newsPicID.",".$AdminID.")";	
			
			mysqli_query($con,$sql) or die(mysql_error());
		
		}
		
		function getNewsList(){
		
			$dbInfo = new DBConfig;
		
			$con = mysqli_connect($dbInfo->getHostname(),$dbInfo->getUsername(),$dbInfo->getPassword(),$dbInfo->getDBName());
			$result = mysqli_query($con,"SELECT * FROM News where wasDeleted = 0;");
			
			while($row = mysqli_fetch_array($result))
			{
				$this->newsList['ID'][] = $row['NewsID'];
				$this->newsList['Title'][] = $row['Title'];
				$this->newsList['PicturePosition'][] = $row['PicturePosition'];
				$this->newsList['Width'][] = $row['Width'];
				$this->newsList['Height'][] = $row['Height'];
			}

			mysqli_close($con);
			
			return $this->newsList;
		
		}
		
		function removeNewsByID($ID){
		
			$dbInfo = new DBConfig;
		
			$con = mysqli_connect($dbInfo->getHostname(),$dbInfo->getUsername(),$dbInfo->getPassword(),$dbInfo->getDBName());
			$sql="UPDATE News SET wasDeleted=1 WHERE NewsID=".$ID."";		
			mysqli_query($con,$sql) or die(mysql_error());
		
		}
		
		function getNewsByID($ID){
		
			$dbInfo = new DBConfig;
		
			$con = mysqli_connect($dbInfo->getHostname(),$dbInfo->getUsername(),$dbInfo->getPassword(),$dbInfo->getDBName());			
			$result = mysqli_query($con,"SELECT * FROM newspicturerecord JOIN News ON News.NewsID = newspicturerecord.NewsID WHERE News.NewsID =".$ID."");

			$picture = new Picture;
			$title = "";
			$content = "";
			$news = new News;
			$picpos = "";
			$width = "";
			$height = "";
			
			while($row = mysqli_fetch_array($result))
			{				
				$picture->getPropsByID($row['PictureID']);	
				$title=$row['Title'];
				$content=$row['Content'];
				$picpos=$row['PicturePosition'];
				$width=$row['Width'];
				$height=$row['Height'];
				
			}
			
			
			$news->setProps($title,$content,$picture,$picpos,$width,$height);
			$news->setID($ID);
			
			return $news;
			
		
		}
		
		
		
		
	
	
	}


?>