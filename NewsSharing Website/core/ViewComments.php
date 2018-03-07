<?php require_once 'Database/CommentsTable.php';
   //File to display all the comments for an article
   session_start();
   
   //When user logs-in or logs-out, previous page is refreshed.
   //To prevent that display all news.
   if(strcasecmp($_SESSION['action'], "logout") == 0) {
      
      include "GetLatestNews.php";
      return;
   }
   
   //If user is logged in, then user can submit a comment
   if(isset($_SESSION['userId'])) {
      
      echo sprintf('%s<form method = "post" action = "ManageComments.php">', "\n\t\t\t");
      echo sprintf('%s<label class = "commentlabel">Enter your comment : </label><br/>', "\n\t\t\t");
      echo sprintf('%s<textarea rows = "3" cols = "90" name = "comment" value = "" class = "commenttext">', "\n\t\t\t", "");
      echo sprintf('%s</textarea><br/>', "\n\t\t\t");
      echo sprintf('%s<div style = "border-bottom : groove black;padding-bottom:10px;margin-bottom:20px">', "\n\t\t\t"); 
      echo sprintf('%s<input type = "submit" name = "submitcommentpost" class = "textpostbutton" Value = "Submit">', "\n\t\t\t\t");
      echo sprintf('%s<input type = "submit" name = "cancelcommentpost" class = "textpostbutton" Value = "Cancel" formnovalidate>', "\n\t\t\t\t");
      echo sprintf('%s</div>', "\n\t\t\t");
      echo sprintf('%s</form>', "\n\t\t\t");
   }
   
   //Get all comments for the article and display them
   $comments = getComments($_SESSION['articleId']);
   
   if(sizeof($comments[0]) === 0) {
      
      if(isset($_SESSION['userId'])) {
         
         //No comments present and user is logged in
         echo sprintf('<img src = "../images/befirsttocomment.jpg" class = "noItems" alt = "No comments to display">');
      } else {
         
         //No comments present and user is not logged in
         echo sprintf('<img src = "../images/nocomments.jpg" class = "noItems" alt = "No comments to display">');
      }
  } else {
      
      for($i = 0; $i < sizeof($comments); $i++) {
         
         echo sprintf('%s<div style = "margin-top : 30px;border-bottom : groove #FBEEE6">', "\n\t\t\t");
         echo sprintf('%s<textarea rows = "1" cols = "90" readonly style = "border-style:none">%s</textarea>', "\n\t\t\t",  $comments[$i][1]);
         
         //User who submitted this particular comment is viewing the page. User can update or delete it.
         if(strcasecmp($_SESSION['userId'], $comments[$i][0]) == 0) {
            echo sprintf('%s<div>', "\n\t\t\t\t");
            echo sprintf('%s<a href="UpdateComment.php?cId=%d" name = "update" class = "linkbutton">Update</a>', "\n\t\t\t\t\t", $comments[$i][2], $comments[$i][2]);
            echo sprintf('%s<a href = "ManageComments.php?cId=%d" name = "delete" class = "linkbutton">Delete</a>', "\n\t\t\t\t\t", $comments[$i][2]);
            echo sprintf('%s</div>', "\n\t\t\t\t");
         }
         echo sprintf('%s</div>', "\n\t\t\t");
      }
   }
?>