<?php
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	//Load Composer's autoloader
	require 'vendor/autoload.php';

	error_reporting();
	ini_set('display_errors',E_ALL);

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

	$errors = array();
		$email = $conn->real_escape_string($_POST["email"]);
		
		//$email = 'jagdishchandra@enacteservices.com';

		$data = $conn->query("SELECT * FROM i_users WHERE user_email='$email'");

		if($data->num_rows > 0){
			$row = mysqli_fetch_row($data);

			//echo"<pre>";print_r($row);

			$str = "0123456789qwertyuiopasdfghjklzxcvbnm";
			$str = str_shuffle($str);
			$str = substr($str,0,31);
			$url = "<a href='http://52.66.56.38/iPanel/resetPassword.php?key=$str'>Reset Password</a>";
			
			$mail = new PHPMailer();                              // Passing `true` enables exceptions
		
		    //$mail->SMTPDebug = 1;                                 // Enable verbose debug output
		    $mail->isSMTP();                                      // Set mailer to use SMTP
		    $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
		    $mail->SMTPAuth = true;                               // Enable SMTP authentication
		    $mail->Username = 'jagdish.enact@gmail.com';                 // SMTP username
		    $mail->Password = 'adobemuse';                           // SMTP password
		    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
		    $mail->Port = 587;                                    // TCP port to connect to
		    //Recipients
		    $mail->setFrom('abc@gmail.com', 'Wave Exchange');
		    $mail->addAddress($email);     // Add a recipient

		    $body = 'To reset your password, please click on this: '.$url;
		    //Content
		    $mail->isHTML(true);                                  // Set email format to HTML
		    $mail->Subject = 'Reset Password';
		    $mail->Body    = $body;
		   	$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

		    
		    if($mail->send()){
		    	$check_exists = $conn->query("SELECT user_id FROM i_forgotPwd WHERE user_id='$row[0]'");
		    	if($check_exists->num_rows > 0){
		    		$conn->query("UPDATE i_forgotPwd SET reset_key='$str' WHERE user_id='$row[0]'");
		    	}else{
		    		$conn->query("INSERT INTO i_forgotPwd VALUES('','$row[0]','$str')");
		    	}
				$response["status"] = "success";
				header('Content-Type:application/json;');
		    }
			
		}else{
			$response["error"] = "Your email doesn't exist.";
			header('Content-Type:application/json;');
		}
	    echo json_encode($response);

	mysqli_close($conn);
?>