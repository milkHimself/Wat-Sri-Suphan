<?php

	include_once('dbconfig.php');
	include_once('touristattraction.php');
	include_once('news.php');

	class SearchResult{
	
		public $searchResult;
	
		function searchFromKeyword($keyword){
					
			$dbInfo = new DBConfig;
			
			$con = mysqli_connect($dbInfo->getHostname(),$dbInfo->getUsername(),$dbInfo->getPassword(),$dbInfo->getDBName());
			$result = mysqli_query($con,"SELECT * FROM attraction WHERE MATCH(Title,Description) AGAINST ('+".$keyword."*' IN BOOLEAN MODE);");
			
			while($row = mysqli_fetch_array($result))
			{
				$this->searchResult['Type'][] = "1";
				$this->searchResult['ID'][] = $row['AttractionID'];
				$this->searchResult['Title'][] = $row['Title'];
				$this->searchResult['Content'][] = $row['Description'];
			}
		
			$con = mysqli_connect($dbInfo->getHostname(),$dbInfo->getUsername(),$dbInfo->getPassword(),$dbInfo->getDBName());
			$result = mysqli_query($con,"SELECT * FROM news WHERE MATCH(Title,Content) AGAINST ('+".$keyword."*' IN BOOLEAN MODE);");
			
			while($row = mysqli_fetch_array($result))
			{
				$this->searchResult['Type'][] = "2";
				$this->searchResult['ID'][] = $row['NewsID'];
				$this->searchResult['Title'][] = $row['Title'];
				$this->searchResult['Content'][] = $row['Content'];
			}	
			

			mysqli_close($con);
			
			return $this->searchResult;
		
		}
	
	}

	/*$s = new SearchResult;
	print_r($s -> searchFromKeyword("Your Touch"));*/

?>