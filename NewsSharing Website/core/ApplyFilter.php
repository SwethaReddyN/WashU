<?php require_once 'Database/ArticlesTable.php';
   //Filters news based on user selected category(ies)
   
   session_start();
   
   //When user logs-in or logs-out, previous page is refreshed.
   //To prevent that, if user logsout or logsin while on filter results
   //page, then display all the news.
   if((strcasecmp($_SESSION['action'], "logout") == 0)
         || strcasecmp($_SESSION['action'], "login") == 0) {
      
      include "GetLatestNews.php";
      return;
   }
   
   if($_SERVER['REQUEST_METHOD'] == 'POST') {         
     //User selected atleast one category, display news in that category(ies).
     if(!empty($_POST['category'])) {

         $results = getNewsByCategory($_POST['category']);
         include_once "../pages/DisplayNews.php";
         displayList($results);
      } else {
         
         //User submitted form without selecting any category.
         //Display message and all news.
         $_SESSION['action'] = "filter";
         $_SESSION['view'] = "all";
         echo '<h3> No Category Selected. Displaying all news</h3>';
         include_once "GetLatestNews.php";
      }
   }
?>