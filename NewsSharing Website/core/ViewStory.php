<?php require_once 'Database/ArticlesTable.php';
   //File to display all an article and its comments
   
   session_start();
   
   //When user logs-in or logs-out, previous page is refreshed.
   //To prevent that display all the news.
   if((strcasecmp($_SESSION['action'], "logout") == 0)
         || strcasecmp($_SESSION['action'], "login") == 0) {
      
      include "GetLatestNews.php";
      return;
   }
   
   $articleId;
   if(isset($_GET) && strlen($_GET['aId']) !== 0) {
      
      $articleId = $_GET['aId'];
      $_SESSION['articleId'] = $articleId;
   }
   else {
      $articleId = $_SESSION['articleId'];
   }
   
   //Determine if the user who submitted the article is
   //viewing it
   $results = getArticle($articleId);
   $isOwner = "false";
   
   if(isset($_SESSION) && isset($_SESSION['userId'])) {
 
      if(strcmp ($results[3], $_SESSION['userId']) === 0) {
         
         $_SESSION['articleId'] = $articleId;
         $isOwner = "true";
      }
   }

   echo sprintf('<!DOCTYPE html>%s<html>', "\n");
   echo sprintf('%s<head>', "\n\t");
   echo sprintf('%s<title>NewsShare</title>', "\n\t\t");
   echo sprintf('%s<link rel = "stylesheet" type = "text/css" href = "./../pages/NewsShare.css?version=22">', "\n\t\t");
   echo sprintf('%s</head>', "\n\t");
   
   echo sprintf('%s<body>', "\n\t");
   
   echo sprintf('%s<div class = "story"', "\n\t\t");
   echo sprintf('%s<h1><u>Title :</u> %s</h1>', "\n\t\t\t", htmlentities($results[0]));
   if(strlen($results[1]) > 0)
      echo sprintf('%s<h5 class = "url">Link : <a href = "%s" target = "_blank">%s</a></h5>',
                   "\n\t\t\t", htmlentities($results[1]), htmlentities($results[1]));
   echo sprintf('%s<br><br><p class = "text">%s</p>', "\n\t\t\t", htmlentities($results[2]));
   
   //User who submitted the story is viewing it.
   //Can update or delete the story
   if($isOwner === "true") {
      
      echo sprintf('%s<div>', "\n\t\t\t");
      echo sprintf('%s<a href="../pages/UpdateStory.php" class = "linkbutton">Update</a>', "\n\t\t\t\t");
      echo sprintf('%s<a href = "DeleteStory.php" class = "linkbutton">Delete</a>', "\n\t\t\t\t\t");
      
      $_SESSION['title'] = $results[0];
      $_SESSION['url'] = $results[1];
      $_SESSION['text'] = $results[2];
      $_SESSION['category'] = $results[4];
      echo sprintf('%s</div>', "\n\t\t\t");
   }
   echo sprintf('%s</div>', "\n\t\t");
   
   //View Comments
   echo sprintf('%s<div class = "comments">', "\n\t\t");
   include "ViewComments.php";
   echo sprintf('%s</div>', "\n\t\t");
   echo sprintf('%s</body>', "\n\t");
   echo sprintf('%s</html>', "\n");
?>