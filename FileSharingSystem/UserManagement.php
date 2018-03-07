<?php

  function isUserRegistered($uname) {

     $path = "../users.txt";
     $fileHandle = fopen($path, 'r');
     $nameFound = false;

     while(($line = fgets($fileHandle)) !== false) {

        if(strpos($line, $uname) !== false) {

           $nameFound = true;
           break;
        }
     }
     fclose($fileHandle);
     return $nameFound;
  }
 
  function createNewUser($uname) {

     $textToBeWritten = $uname . PHP_EOL;     

     $path = "../users.txt";
     $fileHandle = fopen($path, 'a');
     echo $fileHandle;     
     
     if(mkdir("../$uname", 0777) !== false) {

        if(fwrite($fileHandle, $textToBeWritten) === false) {
       
           rmdir("../$uname");
	   $fclose($fileHandle);
	   return false;
        }
	chmod("../$uname", 0777);
	mkdir("../$uname/uploads", 0777);
	mkdir("../$uname/shared", 0777);
	mkdir("../$uname/trash", 0777);
	chmod("../$uname/uploads", 0777);
        chmod("../$uname/shared", 0777);
        chmod("../$uname/trash", 0777);
	fclose($fileHandle);
	return true;
     }
     $fclose($fileHandle);
     return false;
  }

  function deleteUser() {

     $contents = file_get_contents("../users.txt");
     $contents = str_replace($_SESSION['uname'], '', $contents);
     file_put_contents("../users.txt", $contents);
     
     deleteUserDirectory('../' . $_SESSION['uname']);
  } 

  function deleteUserDirectory($dirPath) {

   /*  if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
        $dirPath .= '/';
    }

    $files = glob($dirPath . '*', GLOB_MARK);
    foreach ($files as $file) {
        if (is_dir($file)) {
            deleteUserDirectories($file);
        } else {
            unlink($file);
        }
    }
    rmdir($dirPath); */
    
    if (is_dir($dirPath)) {
 
	$objects = scandir($dirPath); 
     	foreach ($objects as $object) { 
          if ($object != "." && $object != "..") { 
            if (is_dir($dirPath . "/" . $object))
              rmdir($dirPath . "/" . $object);
            else
              unlink($dirPath . "/" . $object); 
          } 
       }
       rmdir($dir); 
     } 
  }
?>
