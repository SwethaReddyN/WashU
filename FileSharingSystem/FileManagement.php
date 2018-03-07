<?php
   session_start();

    function isDirEmpty() {

      $dirPath = $_SESSION["dirPath"];
      $dirItems = count(array_diff(scandir($dirPath), array('..', '.')));

      if($dirItems === 0) {
	      
         return true;
      } else {

         return false;
      }   
   }
	
   function displayFilesAndFolders() {

      $dirPath = $_SESSION["dirPath"];
      $filesList = scandir($dirPath);
      $files_n = count($filesList);
      $filesList = array_diff($filesList, array('..', '.'));
      
      $i = 2;
      $index = 0;
      $display = sprintf("<form id = \"deleteRow\" method = \"post\" action = \"DeleteRow.php\">");
      
      $display .= sprintf("\n\t<div>\n\t<ul class = \"filesList\">");

      while($i < $files_n) {  

      	    $display .= sprintf("\n\t<li class = \"fileRow\" name = \"listIndex_%d\">\n\t<div class = \"row\">", $index);

	    if (is_dir($dirPath . '/' . $filesList[$i])) {

          $display .= sprintf("\n\t<img src = \"images/folder.png\" class = \"rowImg\" alt = \"D\">");
        } else {

          $display .= sprintf("\n\t<img src = \"images/file.png\" class = \"rowImg\" alt = \"F\">");
        }

	$display .= sprintf("<input type = \"submit\" name = \"inputField\" value = \"%s\" readonly>", $filesList[$i]);
	$display .= sprintf("\n\t<input type = \"image\" src = \"images/delete.png\" name =\"deleteIndex\" value =\"%s\" class = \"rowDelete\">", $filesList[$i]);
      	$display .= sprintf("\n\t</div>\n\t</li>");
	
	$i++;
	
      }

      $display .= sprintf("\n\t</div>\n\t</li>");
      $display .= sprintf("\n\t</ul>\n\t</div></form>");
     
      return $display;		   				
   }
?>
