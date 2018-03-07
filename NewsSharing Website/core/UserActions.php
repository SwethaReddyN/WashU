<?php require_once 'Database/UserTable.php';
   //File to handle user actions - login, logout and register
   
   session_start();
   $GLOBALS[$errorMsg] = "";
   if(isset($_POST['login'])) {
      
      processLogin();
   } else if(isset($_POST['register'])) {
      
      processRegister();
   } else if(isset($_POST['logout'])) {
      
      unset($_SESSION);
      session_destroy();
      session_start();
      $_SESSION['action'] = "logout";
      include "../pages/LoginUser.php";
   }
   
   //process user login request
   function processLogin() {
      
      if(isUserNamePresentInTable($_POST['uname']) === false) {
         
         //User not registered. Redirect to register page
         $GLOBALS[$errorMsg] = "Please register first";
         include "../pages/Login.php";
      } else if(isValidPassword($_POST['uname'], $_POST['pwd']) === false) {
      
         //invalid password.
         $GLOBALS[$errorMsg] = "incorrect password";
         include "../pages/LoginUser.php";
      } else {
         
         //User logged in
         $_SESSION['userId'] = $GLOBALS[$userId];
         $_SESSION['action'] = "login";
         include "../pages/LinksToSubmitStories.php";
      }
   }
   
   //process user register request
   function processRegister() {
      
      if(isUserNamePresentInTable($_POST['uname']) === true) {
         //User already registered
         $GLOBALS[$errorMsg] = "username already in use.";
         include "../pages/RegisterUser.php";
      } else {
         
         //Add user to the users table
         addUser($_POST['uname'], $_POST['pwd']);
         include "../pages/LoginUser.php";
      }
   }
?>