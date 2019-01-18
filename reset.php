<?php
		$servername = "localhost";
		$username = "ipanel";
		$password = "ipanelgullu";
		$dbname = "ipanel";

		//Create connection
		$conn = mysqli_connect($servername, $username, $password, $dbname);
		// Check connection
		if (!$conn) {
		    die("Connection failed: " . mysqli_connect_error());
		}

		$key = $conn->real_escape_string($_POST["key"]);

		$forgotPassData = $conn->query("SELECT * FROM i_forgotPwd WHERE reset_key='$key'");
		$forgotPassDatarow = mysqli_fetch_row($forgotPassData);
		
		if($forgotPassData->num_rows > 0){

			$password = $conn->real_escape_string(md5($_POST["password"]));
			$Confirmpassword = $conn->real_escape_string(md5($_POST["confirmpassword"]));
				
			if($password == $Confirmpassword){
				$conn->query("UPDATE i_users SET user_password='$password' WHERE user_id='$forgotPassDatarow[1]'");
				$conn->query("DELETE FROM i_forgotPwd WHERE user_id='$forgotPassDatarow[1]'");
			}
		}
			
?>