<?php require_once 'Database/ArticlesTable.php';
  //Get latest news : view = "all" or "my news"
   //If view is my news, then only those stories that the user with
   //userId submitted will be returned.
   //Otherwise all news will be returned
  
   session_start();
  
   //When user logs-in or logs-out, previous page is refreshed.
   //To prevent that, if action variable is set then, display all the news.
   if(isset($_SESSION['action']) === false) {
    
      if(isset($_POST['myposts'])) {
    
         if(isset($_SESSION['userId'])) {
            
            //user trying to view my news after loggin 
            $_SESSION['view'] = "myposts";
         } else {
      
            //user trying to view my news without loggin .
            //Display error message
            $_SESSION['view'] = "all";
            echo sprintf('<h2 style="text-align:center;">My Posts</h2>');
            echo sprintf('<img src = "../images/notloggedin.png" class = "noItems" alt = "Not logged in">');
            return;
         }  
      } else {
      
         $_SESSION['view'] = "all";
      }
   }
   
   //To display current view on page
   $viewText = "Latest News";
   if(strcasecmp($_SESSION['view'], "myposts") == 0)
      $viewText = "My News";
   $_SESSION['viewText'] = $viewText;
   
   //after using action variable, unset it from session
   unset($_SESSION['action']);
   $results = getLatestNews($_SESSION['view'], $_SESSION['userId']);
   
   include_once "../pages/DisplayNews.php";
   displayList($results);
  
   echo sprintf('%s</body>', "\n\t\n");
   
   echo sprintf('</html>');
?>