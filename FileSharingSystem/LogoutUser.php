<?php require 'UserManagement.php';

  session_start();  
  if(isset($_POST["logout"])) {
   
    session_destroy();
    echo "You have logged out. You will be redirected to Login page shortly";
    header('Refresh:1, URL = FileShareLogin.html');
    exit(); 
  } else if(isset($_POST["deleteUser"])){

     deleteUser();
     session_destroy();
     echo "Your account is deleted.";
     header('Refresh:1, URL = FileShareRegister.html');
     exit(); 
  }  
?>
