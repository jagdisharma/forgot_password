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
        <style type="text/css">
        	.spinnermodal {
		        background-color: #FFFFFF;
		        height: 100%;
		        left: 0;
		        opacity: 0.5;
		        position: fixed;
		        top: 0;
		        width: 100%;
		        z-index: 100000;
		    }
        </style>
    </head>
   
	<body>
		<div class="forgotMain-Div">
			
			<h2>Reset your password</h2>
				<form autocomplete="off" method="POST" action="forgotPassword.php" class="forgotPassword">
					<div class="formfields">
						<lable>Enter your email address and we will send you a link to reset your password.</lable>
						<input type="text" name="email" placeholder="Enter your email address" id="email" onblur="validateEmail(this);" class="textfield form-control" />
						<p id="message" style="color:red;"></p>
						<input type="submit" name="forgotPass" id="forgotPass" value="Send password reset email" class="btn resetbtn">
					</div>
					
					
					<div id="messageDisplay">						
					</div>
				</form>

				
		</div>
		<div class="spinnermodal" id="progressbar" style="display: none; z-index: 10001">
		  <div style="position: fixed; z-index: 10001; top: 45%; left: 46%; height:65px">
		      <img src="load.gif" alt="Loading..." />
		    </div>
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
     
      $(function () {
        $("form").submit(function(event){
        	var email = document.getElementById("email");

        	if(email.value != ""){
        		event.preventDefault();// using this page stop being refreshing 
		        $.ajax({
		            type: 'POST',
		            url: 'forgot.php',
		            data: $('form').serialize(),
		            async:false,
					beforeSend: function () { showLoader(); },
		            success: function (data) {
		            	hideLoader(); 
		            },complete: function (datanew) {
			            	if(datanew.responseJSON.status=="success"){
			            	 	$(".formfields").hide();
			            	 	$("#message").hide();
			            	 	
			            		$("#messageDisplay").html('<lable class="message" >Check your email for a link to reset your password. If it doesn\'t appear within a few minutes, check your spam folder.</lable>');    
					        }else{
					        	$('#message').text(datanew.responseJSON.error);
					        }
				     },
		            dataType: "json"
		        });
        	}else{
        		alert('Invalid Email Address');
		        return false;
        	}
			
	    });
      });

      	function showLoader() {
		    $("#progressbar").css("display", "");
		}

		function hideLoader() {
		    setTimeout(function () {
		        $("#progressbar").css("display", "none");
		    }, 1000);
		}

      function validateEmail(emailField){
      		
      			var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;

		        if (reg.test(emailField.value) == false) 
		        {
		            alert('Invalid Email Address');
		            return false;
		        }
		        return true;
		}
    </script>
    </body>
</html>

	<script type="text/javascript" src="<?php echo $siteUrl; ?>default.js"></script>