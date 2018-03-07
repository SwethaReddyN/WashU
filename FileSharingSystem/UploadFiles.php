<?php

   session_start();
   $uploadOk = 1;
  
   
   $target_dir = $_SESSION["selectedDirectory"];
   if($target_dir === "shared" || $target_dir === "trash")
      $target_dir = "/uploads";
   else if($_SESSION["currentDirectory"] !== "null")
      $target_dir = "/uploads/" . $_SESSION["currentDirectory"];
   else
      $target_dir = "/uploads";
    
   $dirPath = "../" . $_SESSION["uname"] . "/" . $target_dir . "/"; 
   $target_file = $dirPath . basename($_FILES["fileToUpload"]["name"]);

   if (file_exists($target_file)) {
     echo "Sorry, file already exists.";
     $uploadOk = 0;
   } 

   // Check file size	
   if ($_FILES["fileToUpload"]["size"] > 2100000) {

    echo "Sorry, your file is too large.";
    $uploadOk = 0;
   }

   if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
   // if everything is ok, try to upload file
  } else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";        
	//include 'UserContents.php';
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>