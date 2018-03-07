<?php

   //User login form - 
   echo sprintf('<form method = "POST" action = "../core/UserActions.php" name = "usernameForm" target = "loginFrame">');
   echo sprintf('%s<div>', "\n\t");
   echo sprintf('%s<div>', "\n\t\t");
   echo sprintf('%s<label>Enter User Name : </label>', "\n\t\t\t");
   echo sprintf('%s<input type = "text" name = "uname" value = "" required pattern = "[a-zA-Z0-9_-]{5,16}"' .
                'title = "Must contain only numbers, letters, hyphen, underscore, and at least 5 or more characters"><br/><br/>', "\n\t\t\t");
   echo sprintf('%s</div>', "\n\t\t");
   
   echo sprintf('%s<div>', "\n\t\t");
   echo sprintf('%s<label>Enter Password  : </label>', "\n\t\t\t");
   echo sprintf('%s<input type = "password" name = "pwd" value = "" required pattern = "[a-zA-Z0-9_-]{8,16}"' .
                'title = "Must contain only numbers, letters, hyphen, underscore, and at least 8 or more characters"><br/><br/><br/>', "\n\t\t\t");
   echo sprintf('%s</div>', "\n\t\t");
   
   echo sprintf('%s<div class = "loginFormButtons">', "\n\t\t");
   echo sprintf('%s<input type = "submit" id = "login" class = "button" value = "Login" name = "login"/>', "\n\t\t\t");
   echo sprintf('%s<input type = "reset" id = "reset" class = "button" value = "Reset"/>', "\n\t\t\t");
   echo sprintf('%s</div>', "\n\t\t");
   
   echo sprintf('%s<h5 style="color:red;">%s</h5>', "\n\t\t", $GLOBALS[$errorMsg]);
   
   //User can click on register link and go to register page
   echo sprintf('%s<div>', "\n\t\t");
   echo sprintf('%s<h4>Dont have an account? <a href="../pages/RegisterUser.php">Sign Up</a></h4>', "\n\t\t\t");
   echo sprintf('%s</div>', "\n\t\t");
   echo sprintf('%s</div>', "\n\t"); 
   echo sprintf('%s</form>', "\n");;
?>