<html>
	<head>
        <title>Wave Admin</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport" />
        
        <link rel="stylesheet" type="text/css" href="style.css" />
        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
        <link rel='stylesheet' id='fontawesome-css' href='https://use.fontawesome.com/releases/v5.0.1/css/all.css?ver=4.9.1' type='text/css' media='all' />
        <link rel="stylesheet" href="css/metisMenu.min.css">
        <link rel="stylesheet" href="css/metisMenu-vertical.css">
        <link rel="stylesheet" href="css/meanmenu.min.css">
        <link rel="stylesheet" href="css/nebular-icons.css">
        <link rel="stylesheet" href="fonts/Exo/stylesheet.css">
        <link rel="stylesheet" href="css/jquery.mCustomScrollbar.css" />
        <link rel="icon" type="images/png" href="images/favicon.png">
        <link rel="icon" type="images/x-icon" href="images/favicon.ico">
<?php
	/*error_reporting();
	ini_set('display_errors',E_ALL);
*/

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

	$newkey = $_GET["key"];

	$key = $conn->query("SELECT id FROM i_forgotPwd WHERE reset_key='$newkey'");
	//$keydata = mysqli_fetch_row($forgotPassData);

	//echo"<pre>";print_r($key);

	if(isset($_GET["key"]) && $key->num_rows > 0){
?>

         <style type="text/css">
        	button.btn.loginbtn {
			    background: #40dc7e;
			    color: #fff;
			    width: 100%;
			    font-size: 16px;
			}
        </style>
    </head>

	<body>
		<div class="forgotMain-Div">
			<form method="POST" action="resetPassword.php" class="forgotPassword reset">
				<div class="formfields">
					<p>
						<label>Password:</label>
						<input type="password" name="password" id="password" class="textfield form-control"  />
					</p>
					<p>
						<label>Confirm Password:</label>
						<input type="password" name="confirmpassword" id="confirmpassword" class="textfield form-control" />
						<input type="hidden" name="key" value="<?php echo $_GET['key']; ?>" />
					</p>
					<p>Make sure your password should contain aleast One Uppercase Letter, One Lowercase Letter, One numeric digit and One Special Charater.</p>

					<input type="button" name="changePass" id="changePass" value="Change password" class="btn resetbtn">


					<lable id="message" style="display: none">Enter a valid password.</lable>
				</div>
				<lable class="message" style="display: none">Your Password has been changed.</lable>
			</form>
		</div>
	
		<script src="js/jquery-1.12.4.min.js"></script>
	    <script src="js/bootstrap.min.js"></script> 
	    <script src="js/metisMenu.min.js"></script>
		<script src="js/metisMenu-active.js"></script>
		<script src="js/jquery.meanmenu.js"></script>
		<script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
	    <script>
	        $(".leftHeading").click(function () {
	            $(this).toggleClass("openPanel");
	        });
	    </script>

	    <script>
	
			$("#changePass").click(function(event){
				var password = document.getElementById("password");
				var confpassword = document.getElementById("confirmpassword");
				
			  // Validate lowercase letters
			  if(password.value == confpassword.value){
				  var lowerCaseLetters = /[a-z]/g;
				  var numbers = /[0-9]/g;
				  var format = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/g;
				  var upperCaseLetters = /[A-Z]/g;
			
				  
				  if(password.value.match(upperCaseLetters) && password.value.match(numbers) && password.value.match(format) && password.value.match(lowerCaseLetters) ){ 
				    $("#message").hide();
				    event.preventDefault();// using this page stop being refreshing 
			        $.ajax({
			            type: 'POST',
			            url: 'reset.php',
			            data: $('form').serialize(),
			            success: function (data) {
			            	$(".formfields").hide();
			            	$(".message").show();           
			            },
			        }); 
				  } else {
				    $("#message").show(); 
				  }
				 }else{
				 	$("#message").show();
				 }
			});
		</script>

	        
	    </body>
	</html>

	<script type="text/javascript" src="<?php echo $siteUrl; ?>default.js"></script>

<?php }else{?>
        <style type="text/css">
        	.Main{
        		margin: 100px auto;
			    width: 800px;
			    overflow: hidden;
        	}
        </style>
    </head>

	<body>
		<div class="Main">
			<h2>It looks like you clicked on an invalid reset password link.</h2>
		</div>
	
		<script src="js/jquery-1.12.4.min.js"></script>
	    <script src="js/bootstrap.min.js"></script> 
	    <script src="js/metisMenu.min.js"></script>
		<script src="js/metisMenu-active.js"></script>
		<script src="js/jquery.meanmenu.js"></script>
		<script src="js/jquery.mCustomScrollbar.concat.min.js"></script>

	        
	    </body>
	</html>
<?php	}
?>