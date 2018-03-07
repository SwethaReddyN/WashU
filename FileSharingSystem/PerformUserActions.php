<?php

if($_POST['uploadOptions'] === "uploadFile") {
      printf("<form id = \"fileUploadForm\" method = \"post\" action = \"UploadFiles.php\" target = \"contentFrame\" enctype=\"multipart/form-data\">" . "<div class = \"fileInputContainer\">" . 
	      "<input type = \"file\" name = \"fileToUpload\" id = \"fileToUpload\"><input type = \"submit\" name = \"submitFile\" id = \"submitFile\" class = \"button\" value = \"Submit\"\">" . 
	      "</div></form>");
} else {

     printf("<form id = \"createFolderForm\" method = \"post\" action = \"CreateFolder.php\" target = \"contentFrame\">" . "<div class = \"fileInputContainer\">" .
              "<input type = \"text\" name = \"folderName\" id = \"folderName\" required><input type = \"submit\" name = \"submitFile\" id = \"submitFile\" class = \"button\" value = \"submit\"\">" . 
	      "</div></form>");

}
?>