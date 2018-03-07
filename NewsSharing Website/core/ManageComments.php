<?php require_once 'Database/CommentsTable.php';
   //File to update, delete or insert a comment
   
   session_start();
   
   //When user logs-in or logs-out, previous page is refreshed.
   //To prevent that then display all the news.
   if((strcasecmp($_SESSION['action'], "logout") == 0)) {
      
      include "GetLatestNews.php";
      return;
   }
   
   if(isset($_POST['cancelcommentpost'])) {
      
      //If user cancels updating a comment,then the story and its 
      //comments are displayed
      include "ViewStory.php";
   } else if(isset($_POST['submitcommentpost'])) {
      
      //Add comment to comments table
      $userId = $_SESSION['userId'];
      $articleId = $_SESSION['articleId'];
      $text = $_POST['comment'];
      addComment($userId, $articleId, $text);
      include 'ViewStory.php';
   } else if(isset($_GET)) {
      
      $commentId = $_GET['cId'];
      if(isset($_GET['cId'])) {
      
         //delete comment from comments table   
         deleteComment($commentId);
      } else {
         
         //update comment in comments table
         if(strlen($_POST['commentText']) != 0) 
            updateComment($_POST['commentId'], $_POST['commentText']);
      }
      include 'ViewStory.php';
   } else
?>