<?php

   //Display news list in proper format
   function displayList($results) {
      
      if(sizeof($results[0]) === 0) {
       
         //No news or articles to display.
         //Displays error message
         echo sprintf('<h2 style="text-align:center;">%s</h2>', $_SESSION['viewText']);
         echo sprintf('<img src = "../images/nonews.png" class = "noItems" alt = "No news to display">');
      } else {
      
         echo sprintf('<!DOCTYPE html>%s<html>', "\n");
         echo sprintf('%s<head>', "\n\t");
         echo sprintf('%s<title>NewsShare</title>', "\n\t\t");
         echo sprintf('%s<link rel = "stylesheet" type = "text/css" href = "NewsShare.css?version=21">', "\n\t\t");
         echo sprintf('%s</head>', "\n\t");
       
         echo sprintf('%s<body>', "\n\t");
         echo sprintf('<h2 style="text-align:center;">%s</h2>', htmlentities($_SESSION['viewText']));
         echo sprintf('<div id = "listcontainer">');
         for($i = 0; $i < sizeof($results); $i++) {
         
            if(strlen($results[$i][3]) > 0) {
            
               //Text post
               echo sprintf('%s<img src = "../images/file.png" class = "rowImage" alt = "L">', "\n\t\t\t");
               echo sprintf('%s<a class = "row" href = "../core/ViewStory.php?aId=%d">', "\n\t\t\t", htmlentities($results[$i][0]));
               echo sprintf('%s', htmlentities($results[$i][1]));
               echo sprintf('</a><br/><br/>');
            } else {
               
               //URL post
               echo sprintf('%s<img src = "../images/link.png" class = "rowImage" alt = "L">', "\n\t\t\t");
               echo sprintf('%s<a href = "%s" target="_blank">', "\n\t\t\t", htmlentities($results[$i][2]));
               echo sprintf('%s', htmlentities($results[$i][1]));
               echo sprintf('</a>');
               //If user who submitted the URL post is viewing,
               //then display delete option
               if(strcasecmp($results[$i][4], $_SESSION['userId']) == 0) {
                  
                  echo sprintf('%s<a href = "../core/DeleteLink.php?aId=%d"> ' .
                               '<img border = "0" alt = "D" src = "../images/delete.png"></a>', "\n\t\t\t", htmlentities($results[$i][0]));
               }
               echo sprintf('<br/><br/>');
            }
         }
       
         echo sprintf('</div>');
      }
   }
?>