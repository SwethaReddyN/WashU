<!DOCTYPE html>

<html>

   <head>

      <title>User Contents</title>
      <link rel = "stylesheet" type = "text/css" href = "FileShare.css">
   </head>
   
   <body>

      <?php require 'FileManagement.php';
           
	    if($_SESSION["dirPath"] === "null") {

              $uname = $_SESSION["uname"];
	      if((isset($_POST['action']) === true)/*$_SESSION["initialPageLogin"] !== true*/) {
	        
	         if(isset($_POST['action']) === true) { 
	           
	           $dirPath    = '../' . $uname. '/' . $_POST['action'];
	           $_SESSION["selectedDirectory"] = $_POST['action'];     
	           $_SESSION["currentDirectory"] = "null";
	         } else {

	            $dirPath = '../' . $uname . '/' . $_SESSION["selectedDirectory"]; 
	            //$_SESSION["currentDirectory"] = "null";
	         }
	      } else {

                 $_SESSION["selectedDirectory"] = "uploads";
	         $dirPath    = '../' . $uname . '/uploads';
              }
	      $_SESSION["dirPath"] = $dirPath;
       	   } else 
	    
	   $_SESSION["initialPageLogin"] = 0;
	   
	   if(isDirEmpty() === true) {

              printf('<img src = "images/NoItems.png" class = "noItems" alt = "There are no items in this folder">');

           } else {

              printf(displayFilesAndFolders());
           }

       	   $_SESSION["dirPath"] = "null";
      ?>
   </body>
</html>
