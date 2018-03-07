<?php

   $errorMsg = ""; //Login error message
   $userId = 0;//Set userId in session variable once user logs in
   
   session_start();
   //Destroy session when page is refreshed
   if(isset($_SESSION['userId'])) {
      session_destroy();
      session_start();
   }
   //By default, display all the news
   $_SESSION['view'] = "all";
   
   //include html header
   echo sprintf('<!DOCTYPE html>%s<html>', "\n");
   include "pages/HTMLHeader.php";

   // build main structure ##
   echo sprintf('%s<body>', "\n\t");
   echo sprintf('%s<div class = "container">', "\n\t\t");
   
   //include page header
   include "pages/PageHeader.php";
   
   //include contents frame
   include "pages/Contents.php";
   
   //close main structure
   echo sprintf('%s</div>', "\n\t\t");
   echo sprintf('%s</body>', "\n\t");
   
   //close html header
   echo sprintf('%s</html>', "\n");
?>
