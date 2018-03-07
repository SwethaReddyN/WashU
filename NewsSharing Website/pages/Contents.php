<?php
   //Defines - contentFrame where all the articles(list or complete article) are displayed
   //LoginFrame - user can register, login and logout
   //FilterFrame - user can filter news according based on a category
   
   $indentation = "\n\t\t\t";
   
   echo sprintf('%s<div class = "contents">', $indentation);
   
   //frame to displays news list or news
   echo sprintf('%s%s<div class = "column content">', $indentation, "\t");
   echo sprintf('%s%s<iframe src = "core/GetLatestNews.php" id = "contentFrame" name = "contentFrame" scrolling="yes"></iframe>', $indentation, "\t\t");
   echo sprintf('%s%s</div>', $indentation, "\t");
   
   //login Frame
   echo sprintf('%s%s<div class = "column sideMenu">', $indentation, "\t");
   echo sprintf('%s%s<div class = "loginForm">', $indentation, "\t\t");
   echo sprintf('%s%s<iframe src = "pages/LoginUser.php" id = "loginFrame" name = "loginFrame"></iframe>', $indentation, "\t\t\t");
   echo sprintf('%s%s</div>', $indentation, "\t\t");
   
   //Filter Frame
   echo sprintf('%s%s<div class = "loginForm">', $indentation, "\t\t");
   echo sprintf('%s%s<iframe src = "pages/Filter.html" id = "filterFrame" name = "filterFrame"></iframe>', $indentation, "\t\t\t");
   echo sprintf('%s%s</div>', $indentation, "\t\t");
   
   echo sprintf('%s%s</div>', $indentation, "\t");
   echo sprintf('%s</div>', $indentation);
?>