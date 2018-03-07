<?php

   //html header
   echo sprintf('<!DOCTYPE html>%s<html>', "\n");
   echo sprintf('%s<head>', "\n\t");
   echo sprintf('%s<title>NewsShare</title>', "\n\t\t");
   echo sprintf('%s<link rel = "stylesheet" type = "text/css" href = "NewsShare.css">', "\n\t\t");
   echo sprintf('%s</head>', "\n\t");
   
   // build main structure ##
   echo sprintf('%s<body>', "\n\t");
   
   echo sprintf('%s<form name = "storyForm" method = "POST" action = "../core/ManageNews.php">', "\n\t\t");
   
   //Title
   echo sprintf('%s<label>Title : </label><br/>', "\n\t\t\t");
   echo sprintf('%s<input type = "text" name = "title" value = "" required style="width:700px;"><br/><br/><br/>', "\n\t\t\t");
   
   //URL
   echo sprintf('%s<label>URL : </label><br/>', "\n\t\t\t");
   echo sprintf('%s<input type = "text" name = "url" value = "" required style="width:700px;"  pattern = "(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?"' .
                'title = "Please enter valid url"><br/><br/><br/>', "\n\t\t\t");
   
   //Category
   echo sprintf('%s<label>Category : </label><br/>', "\n\t\t\t");
   
   echo sprintf('%s<select name = "categorydropdown">', "\n\t\t\t");
   echo sprintf('%s<option value = "general" disabled selected = "selected" style="display: none">General News</option>', "\n\t\t\t\t");
   echo sprintf('%s<option value = "general">General News</option>', "\n\t\t\t\t");
   echo sprintf('%s<option value = "sports">Sports</option>', "\n\t\t\t\t");
   echo sprintf('%s<option value = "business">Business</option>', "\n\t\t\t\t");
   echo sprintf('%s<option value = "entertainemnt">Entertainment</option>', "\n\t\t\t\t");
   echo sprintf('%s<option value = "fashion">Fashion</option>', "\n\t\t\t\t");
   echo sprintf('%s<option value = "lifestyle">Lifestyle</option>', "\n\t\t\t\t");
   echo sprintf('%s<option value = "tech">Tech</option>', "\n\t\t\t\t");
   echo sprintf('%s<option value = "environment">Environment</option>', "\n\t\t\t\t");
   echo sprintf('%s</select><br/></br></br></br></br>', "\n\t\t\t");
   
   //Submit the article or cancel the process
   echo sprintf('%s<div>', "\n\t\t\t"); 
   echo sprintf('%s<input type = "submit" name = "submittextpost" class = "textpostbutton" Value = "Submit">', "\n\t\t\t\t");
   echo sprintf('%s<input type = "submit" name = "canceltextpost" class = "textpostbutton" Value = "Cancel" formnovalidate>', "\n\t\t\t\t");
   
   echo sprintf('%s</div>', "\n\t\t\t");
   echo sprintf('%s</form>', "\n\t\t");
   echo sprintf('%s</body>', "\n\t");
   
   //close html header
   echo sprintf('</html>');
?>