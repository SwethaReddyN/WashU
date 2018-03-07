<?php require_once 'FileManagement.php';

      $dirPath    = '../' . $_SESSION['uname'] . '/' . $_SESSION["selectedDirectory"];
      
      if($_SESSION["currentDirectory"] !== "null")
         $dirPath .= '/' . $_SESSION["currentDirectory"];
      if(isset($_POST['deleteIndex']) === true) {

         $fName = $_POST['deleteIndex'];
      	 
	 //If files and folders are being deleted from trash, then delete from file system
	 if($_SESSION["selectedDirectory"] === "trash") {
	    if (is_dir($dirPath . '/' . $fName)) {
	     
	     //delete folder and its child elements from file system
	      array_map('unlink', glob($dirPath . '/' . $fName . "/*"));
	      rmdir($dirPath . '/' . $fName);
	    } else {

	     //delete file from file system
	      unlink($dirPath . '/' . $fName);
	    }
	  } else {
	      	    
              //move files and folder to trash
  	      rename ( $dirPath . '/' . $fName  , '..' . '/' . $_SESSION["uname"] . '/trash/' . $fName);
	  }       
	  $_SESSION["dirPath"] = $dirPath;      	  
	 header('Refresh:1, URL = UserContents.php');
	  exit();
      }
	
	if(isset($_POST['inputField']) === true) {

	   //echo "view content";
	   $fName = $_POST['inputField'];
	     
	   
	   if (is_dir($dirPath . '/' . $fName )) {

	      //If user clicked on directory, then display its contents
	      $_SESSION["currentDirectory"] = $_POST['inputField'];
	      $_SESSION["dirPath"] = $dirPath . '/' . $fName;	     
              header('Refresh:1, URL = UserContents.php');
	      exit();
	   } else {
	     
	     //If user clicked on file, display or open in the browser depending on the file type.
	     $fileType = pathinfo($fName, PATHINFO_EXTENSION);
	     switch ($fileType) {
               
    	       case "bmp":
                 header('Content-type: image/bmp');
        	 break;
    	       case "c":
                 header('Content-type: text/x-c');
        	 break;
    	       case "css":
		 header('Content-type: text/css');
        	 break;
               case "gif":
		 header('Content-type: image/gif');
      		 break;
               case "html":
               header('Content-type: text/html');
               break;
    	       case "java":
               header('Content-type: text/x-java-source');
               break;
    	       case ".js":
               header('Content-type: application/javascript');
               break;
    	       case "jpeg":
    	       case "jpg" :
               header('Content-type: image/jpeg');
               break;
    	       case "mdi" :
               header('Content-type: image/vnd.ms-modi');
               break;
    	       case "xls" :
	       case "csv" :
	       case "xlsx" :
	       case "docx":
               case "ppt" :
	       case "pub" :
	       case "doc";
	        case "tiff" :
	       $type = "application/octet-stream";
	       header("Cache-Control: no-store, no-cache, must-revalidate"); 
               header("Cache-Control: post-check=0, pre-check=0", false); 
               header("Cache-Control: private",false); 
               header("Pragma: no-cache"); 
               header('Content-Type:'. $type); 
               header ("Content-Disposition: attachment; filename=\"". basename($$dirPath . '/' . $fName)."\";"); 
               header("Content-Transfer-Encoding: binary\n"); 
               header ("Content-Length: " . filesize($downloadfile)); 
               break;
    	       case "chm" :
               header('Content-type: application/vnd.ms-htmlhelp');
               break;
    	       case "pbm" :
               header('Content-type: image/x-portable-bitmap');
               break;
    	       case "png" :
               header('Content-type: image/png');
               break;
    	       case "rtf" :
               header('Content-type: application/rtf');
               break;
    	       case "rtx" :
               header('Content-type: text/richtext');
               break;
    	       case "txt" :
               header('Content-type: text/plain');
               break;
    	       case "wsdl" :
               header('Content-type: application/wsdl+xml');
               break;
    	       case "xhtml" :
               header('Content-type: application/xhtml+xml');
               break;
    	       case "xslt" :
               header('Content-type: application/xslt+xml');
               break;
    	       case "zip" :
                 header('Content-type: application/zip');
        	 break;
	       case "pdf" :
	       	 header('Content-type: application/pdf');
		 break;
	     }
	     	     
	     readfile($dirPath . '/' . $fName); 
	  }
      }   
	
	
?>