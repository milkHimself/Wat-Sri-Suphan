<?php

class DBConfig{

	public $DBhostname="localhost";
	public $DBusername="root";
	public $DBpassword="";
	public $DBName="watsrisuphan_website";
		
	function getHostname(){
		
		return $this->DBhostname;
			
	}
		
	function getUsername(){
			
		return $this->DBusername;
		
	}
		
	function getPassword(){
			
		return $this->DBpassword;
		
	}
		
	function getDBName(){
		
		return $this->DBName;
		
	}
	
}

?>