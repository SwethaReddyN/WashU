<?php require_once 'Database/ArticlesTable.php'; 

   session_start();
   if(isset($_POST['canceltextpost'])) {
      
      if(isset($_SESSION['action']))
         unset($_SESSION['action']);
      include "GetLatestNews.php";
   } else if(isset($_POST['submittextpost'])) {
      
      $title = $_POST['title'];
      $text = null;
      if(isset($_POST['story']))
         $text = $_POST['story'];
      $url = null;
      if(isset($_POST['url'])) {
         $url = (strlen($_POST['url']) > 0) ? $_POST['url'] : null;
         if(!is_null($url)) {
            
            if(strcasecmp(substr( $url, 0, 4 ), "http") !== 0) {
               
               $url = "http://" . $url;
            }
         }
      }
      $category = (isset($_POST['categorydropdown'])) ? $_POST['categorydropdown'] : null;
      $userId = $_SESSION['userId']; 
      
      addArticle($userId, $title, $text, $url, $category);
      include "GetLatestNews.php";
   } else if(isset($_POST['updatetextpost'])) {
      
      
      $url = null;
      $text = $_POST['story'];
      if(isset($_POST['url']))
         $url = (strlen($_POST['url']) > 0) ? $_POST['url'] : null;
      $category = (isset($_POST['categorydropdown'])) ? $_POST['categorydropdown'] : null;
      $title = $_POST['title'];
      
      updateArticle($_SESSION['articleId'], $title, $text, $url, $category);
      include "GetLatestNews.php";
   }
?>