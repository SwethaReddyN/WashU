<?php

   //Create User Folders required for a new user
   session_start();
   
   $target_dir = "/uploads/" . $target_dir;
   if (strpbrk($_SESSION['folderName'], "\\/?%*:|\"<>\.") !== FALSE) {
    
      echo "Entered directory name is invalid.";
      exit();
   }

   $target_dir = "/uploads/" . $target_dir;
   $dirPath = "../" . $_SESSION["uname"] . "/uploads/" . $_POST['folderName'];
   
   if(mkdir($dirPath, 0777) !== false) {
   
     chmod($dirPath, 0776);
     echo ("Folder Created Successfully");
   } else {

      echo("Error while creating folder. Please Try again!!");
   }  
?>
