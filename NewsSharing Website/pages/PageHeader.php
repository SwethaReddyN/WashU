<?php
   
   $indentation = "\n\t\t\t";
   //NewsShare Website header - contains logo, and "My news", "Latest News" tabs
   $pageHeaderBody = sprintf('%s<div class = "header">', $indentation);
   
   $pageHeaderBody .= sprintf('%s%s<div class = "logo">NewsShare</div>', $indentation, "\t");
   $pageHeaderBody .= sprintf('%s%s<div class = "topnav">', $indentation, "\t");
   
   $pageHeaderBody .= sprintf('%s%s<form method = "post" action = "core/GetLatestNews.php" target = "contentFrame" name = "headerForm">', $indentation, "\t\t");
   $pageHeaderBody .= sprintf('%s%s<div>', $indentation, "\t\t\t");
   $pageHeaderBody .= sprintf('%s%s<input type = "submit" class = "topnavbuttons" name = "news" value = "Latest News">', $indentation, "\t\t\t\t");
   $pageHeaderBody .= sprintf('%s%s<input type = "submit" class = "topnavbuttons" name = "myposts" value = "My News">', $indentation, "\t\t\t\t");
   $pageHeaderBody .= sprintf('%s%s</div>', $indentation, "\t\t\t");
   $pageHeaderBody .= sprintf('%s%s</form>', $indentation, "\t\t");
   $pageHeaderBody .= sprintf('%s%s</div>', $indentation, "\t");
   
   $pageHeaderBody .= sprintf('%s</div>', $indentation);
   printf($pageHeaderBody);
?>