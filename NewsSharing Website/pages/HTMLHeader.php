<?php
   
   //HTML header for NewsShare Website
   $htmlCode = sprintf('%s<head>', "\n\t");
   $htmlCode .= sprintf('%s<title>NewsShare</title>', "\n\t\t");
   $htmlCode .= sprintf('%s<link rel = "stylesheet" type = "text/css" href = "./pages/NewsShare.css?version=23">', "\n\t\t");
   $htmlCode .= sprintf('%s</head>', "\n\t");
   
   printf($htmlCode);
?>