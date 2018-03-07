<!DOCTYPE html>
<html>
  <head>
  
    <title>FileShare</title>
    <link rel = "stylesheet" type = "text/css" href = "FileShare.css">
  </head>
  <body>

    <script type = "text/javascript">

      function updateViewTitle(action) {
						
      if(action === 'uploads') {
						
          document.getElementById("view").value = "My Uploads";
        } else if(action === 'trash') {
	       		     
          document.getElementById("view").value = "Deleted Files and Folders";
        }
        document.getElementById("action").value = action;
        document.getElementById("contentsForm").submit();
      }

    </script> 
    	      
    <div class = "container">
      <form method = "post" action = "LogoutUser.php">
	<div class="header">
          <img src = "images/logo.png" class = "logo" alt = "FileShare">
          <input type = "text" id = "view" class = "viewFS" name = "view" value = "My Uploads">
	  <input type = "submit" class = "logout" name = "logout" value = "Logout">
	</div>
	</form>

	<div class="clearfix">
          <div class="column menu">
	
	    <form method = "post" action = "PerformUserActions.php" target = "contentFrame">
            <div class = "dropdownList">
	      <select name = "uploadOptions" id = "uploadOptions" class = "uploadOptions" onchange = "this.form.submit();">
		<option disabled selected value = "upload" class = "hiddenOption">New Folder</option>
		<option value = "newFolder">New Folder</option>
		<option value = "uploadFile">Upload File</option>
              </select>
            </div>
	    </form>
	    <form method = "post" action = "UserContents.php" target = "contentFrame" id = "contentsForm">
          
            <ul>
              <li id = "uploads" onclick = "updateViewTitle('uploads');">My Uploads</li>
              <li id = "trash" onclick = "updateViewTitle('trash');">Trash</li>
            </ul>
          </div>

	  <input id = "action" class = "hidden" name = "action"></input>
	  </form>
         <div class="column content">
	    <iframe src = "UserContents.php" id = "contentFrame" name = "contentFrame"/>
	  </div>
	</div>

	<div class="footer">
	</div>
      </form>
    </div>
  </body>
</html>
