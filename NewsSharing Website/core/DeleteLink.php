<?php require_once 'Database/ArticlesTable.php';
   //Delete URL post(article) from DB
   
   $articleId = $_GET['aId'];
   $_SESSION['action'] = "delete";
   deleteArticle($articleId);
   include "GetLatestNews.php";
?>