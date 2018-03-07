<?php require 'UserManagement.php'; 

  if($_SERVER[REQUEST_METHOD] === "POST") {
  
     
	if(isUserRegistered($_POST['uname']) !== false) {
	
	   echo "User Already Registered. Redirecting to login page";
	   header('Refresh: 3; URL = FileShareLogin.html');
	   exit();
	} else {

	   if(createNewUser($_POST['uname']) === false) {

	      echo "Error while regsitering. Please Try again!!!";
	      header('Refresh:3, URL = FileShareRegister.html');
	      exit();
	   } 
	   echo "Account created. Redirecting to login page";
	   header('Refresh:1, URL = FileShare.php');
	   exit();
	}
    }
 
?>