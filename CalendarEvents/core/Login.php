<?php
//If user is already logged in, displays a filter form
//otherwise displays login page
  session_start();
  
  //logged in browser refreshes the browser, then display filter page and not
  //log in page
  if(isset($_SESSION['token'])) {
    //No escaping out as expected output is html content
    echo file_get_contents("Filter.html");
  } else {
    displayLoginPage();
  }
  
  function displayLoginPage() {
?>

<!DOCTYPE HTML>
<html>
  <head>
    <title>Login</title>
    <link rel='stylesheet' href='../CalendarEvents.css' />
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.2.6/jquery.min.js"></script>
    <script src = "UserAccount.js"></script>
  </head>
  <body>
    <div>
      <div>
        <label>Enter User Name : </label>
        <input type = "text" name = "uname" id = "uname" value = "">
        <br/><br/>
      </div>
      <div>
        <label>Enter Password  : </label>
        <input type = "password" name = "pwd" id = "pwd" value = "">
        <br/><br/><br/>
      </div>
      <div class = "loginFormButtons">
        <input type = "submit" id = "login" class = "button" value = "Login"/>
        <input type = "reset" id = "reset" class = "button" value = "Reset"/>
      </div>
    </div>
    <div>
      <h4>Dont have an account? <a href="Register.html">Sign Up</a></h4>
    </div>
  </body>
</html>
<?php
  }
?>