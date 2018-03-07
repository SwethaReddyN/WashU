<?php
   //Displays article details and user can update anything
   //or cancel the process
   include "pages/HTMLHeader.php";
   session_start();
   $_SESSION['action'] = "update";
   echo sprintf('%s<body>', "\n\t");
   
   echo sprintf('%s<form name = "storyForm" method = "POST" action = "../core/ManageNews.php">', "\n\t\t");
   
   echo sprintf('%s<label>Title : </label><br/>', "\n\t\t\t");
   echo sprintf('%s<input type = "text" name = "title" value = "%s" style="width:700px;"><br/><br/><br/>',
                "\n\t\t\t", htmlentities($_SESSION['title']));
   
   echo sprintf('%s<label>Text : </label><br/>', "\n\t\t\t");
   echo sprintf('%s<textarea rows = "10" cols = "90" name = "story">%s</textarea><br/><br/><br/>',
                "\n\t\t\t", htmlentities($_SESSION['text']));
   echo sprintf('%s<label>URL : </label><br/>', "\n\t\t\t");
   echo sprintf('%s<input type = "text" name = "url" value = "%s" style="width:700px;"   pattern = "(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?"' .
                'title = "Please enter valid url"><br/><br/><br/>',
                "\n\t\t\t", htmlentities($_SESSION['url']));
   
   echo sprintf('%s<label>Category : </label><br/>', "\n\t\t\t");
   
   echo sprintf('%s<select name = "categorydropdown">', "\n\t\t\t");
   if(is_null($_SESSION['category']))
      echo sprintf('%s<option value = "none" selected>None</option>', "\n\t\t\t\t");
   else
      echo sprintf('%s<option value = "none">None</option>', "\n\t\t\t\t");
  
   if(!is_null($_SESSION['category']) && strcmp($_SESSION['category'], "general") === 0) 
      echo sprintf('%s<option value = "general" selected>General News</option>', "\n\t\t\t\t");
   else
      echo sprintf('%s<option value = "general">General News</option>', "\n\t\t\t\t");
      
   if(!is_null($_SESSION['category']) && strcmp($_SESSION['category'], "sports") === 0) 
      echo sprintf('%s<option value = "sports" selected>Sports</option>', "\n\t\t\t\t");
   else
      echo sprintf('%s<option value = "sports">Sports</option>', "\n\t\t\t\t");
      
   if(!is_null($_SESSION['category']) && strcmp($_SESSION['category'], "business") === 0) 
      echo sprintf('%s<option value = "business" selected>Business</option>', "\n\t\t\t\t");
   else
      echo sprintf('%s<option value = "business">Business</option>', "\n\t\t\t\t");
      
   if(!is_null($_SESSION['category']) && strcmp($_SESSION['category'], "entertainemnt") === 0)    
      echo sprintf('%s<option value = "entertainemnt" selected>Entertainemnt</option>', "\n\t\t\t\t");
   else
      echo sprintf('%s<option value = "entertainemnt">Entertainemnt</option>', "\n\t\t\t\t");
      
   if(!is_null($_SESSION['category']) && strcmp($_SESSION['category'], "fashion") === 0)  
      echo sprintf('%s<option value = "fashion" selected>Fashion</option>', "\n\t\t\t\t");
   else
      echo sprintf('%s<option value = "fashion">Fashion</option>', "\n\t\t\t\t");
      
   if(!is_null($_SESSION['category']) && strcmp($_SESSION['category'], "lifestyle") === 0)  
      echo sprintf('%s<option value = "lifestyle" selected>Lifestyle</option>', "\n\t\t\t\t");
   else
      echo sprintf('%s<option value = "lifestyle">Lifestyle</option>', "\n\t\t\t\t");
      
   if(!is_null($_SESSION['category']) && strcmp($_SESSION['category'], "tech") === 0)  
      echo sprintf('%s<option value = "tech" selected>Tech</option>', "\n\t\t\t\t");
   else
      echo sprintf('%s<option value = "tech">Tech</option>', "\n\t\t\t\t");
      
   if(!is_null($_SESSION['category']) && strcmp($_SESSION['category'], "environment") === 0)  
      echo sprintf('%s<option value = "environment" selected>Environment</option>', "\n\t\t\t\t");
   else
      echo sprintf('%s<option value = "environment">Environment</option>', "\n\t\t\t\t");
      
   echo sprintf('%s</select><br/></br></br></br></br>', "\n\t\t\t");
  
   echo sprintf('%s<div class = "storybuttons">', "\n\t\t\t"); 
   echo sprintf('%s<input type = "submit" name = "updatetextpost" class = "textpostbutton" Value = "Submit">', "\n\t\t\t\t");
   echo sprintf('%s<input type = "submit" name = "canceltextpost" class = "textpostbutton" Value = "Cancel" formnovalidate>', "\n\t\t\t\t");
   echo sprintf('%s</div>', "\n\t\t\t");
   echo sprintf('%s</form>', "\n\t\t");
   echo sprintf('%s</body>', "\n\t");
   
   //close html header
   echo sprintf('</html>');