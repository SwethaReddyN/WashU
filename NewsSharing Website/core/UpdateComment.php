<!-- File to handle update comments process.
User can enter updated comments in prompt box
This input is updated in comments table-->

<!DOCTYPE html>

<html>

<head>
   <!--Script to check if user entered some
	value in prompt box or cancelled the process -->
   <script type = "text/javascript">
      function displayPrompt() {
			            
         var newComment = prompt("Please enter updated comment");
          if(newComment !== null) {
            
            document.getElementById("commentText").value = newComment;
            document.getElementById("commentId").value = window.location.search.split("=")[1];
          }
          document.getElementById("updateCommentFrame").submit();
          return true;
      }
    </script> 
</head>

  <body onload = "displayPrompt();">
		
    <form id = "updateCommentFrame" action = "ManageComments.php" method = "POST">   
      <div>
        <!-- hidden inputs to hold commentId and commentText. php will get the values from these elements -->
        <input id = "commentId" hidden name = "commentId">
        <input id = "commentText" hidden name = "commentText">
      </div>
    </form>
  </body>
  
   <?php
   
      session_start();
      if((strcasecmp($_SESSION['action'], "logout") == 0) ||
            (strcasecmp($_SESSION['action'], "login") == 0)) {
      
         include "GetLatestNews.php";
         return;
      }
      $commentId = $_GET['cId'];
    ?> 
</html>