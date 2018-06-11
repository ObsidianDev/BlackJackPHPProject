<?php
use ActiveRecord\Model; 
use ArmoredCore\WebObjects\Session;

class DBWork extends Model{
	public function connection(){
		$servername = "localhost";
		$username = "root";
		$password = "";

		// Create connection
		$conn = mysqli_connect($servername, $username, $password);

		// Check connection
		if (!$conn) {
	    	die("Connection failed: " . mysqli_connect_error());
		}
	}
	public function selections($case){
		
	}
}
?>