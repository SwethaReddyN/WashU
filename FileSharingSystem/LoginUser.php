<?php
// Start the session
   session_start();
?>

<!DOCTYPE html>
	  
<html>
	
   <head>
	<title>Login</title>
   </head>
      
   <body>     

      <?php require 'UserManagement.php';

         if($_SERVER['REQUEST_METHOD'] === "POST") {

    	    if(isUserRegistered($_POST['uname']) !== false) {
		
	echo "hmmmm";			 
	       $_SESSION["uname"] = $_POST['uname'];
	       $_SESSION["dirPath"] = "null";
	       $_SESSION["selectedDirectory"] = "uploads";
	       $_SESSION["currentDirectory"] = "null";
	       $_SESSION["initialPageLogin"] = true; 
	       header('Refresh: 1; URL = FileShare.php');
      	       
    	    } else {

      	       echo "Not a registered user. You are being redirected to register page";
      	       header('Refresh:3, URL = FileShareRegister.html');
      	       exit();
    	    }
        }
      ?> 
   </body>
</html>