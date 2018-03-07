<?php require_once 'Database/ArticlesTable.php';
   //Deletes an Text post(article) from DB
   
   session_start();
   $articleId = $_SESSION['articleId'];
   //unset all the article details from session
   unset($_SESSION['articleId']);
   unset($_SESSION['title']);
   unset($_SESSION['url']);
   unset($_SESSION['text']);
   unset($_SESSION['category']);
   
   $_SESSION['action'] = "delete";
   deleteArticle($articleId);
   include "GetLatestNews.php";
?>