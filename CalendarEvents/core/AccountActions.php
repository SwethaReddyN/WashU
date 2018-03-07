<?php require_once 'UsersTable.php';
  //Processes login, register and logout post resquests
  //from client 

  header('Content-Type: application/json');
  if($_POST['action'] === "login") {
     
    processLogin();
  } else if($_POST['action'] === "register") {
     
    processRegister();
  } else if($_POST['action'] === "logout") {
      
    session_start();
    unset($_SESSION);
    session_destroy();
    echo json_encode(array(
      'success' => true,
      'message' => 'session destroyed',
      'userId' => '' . isset($_SESSION['userId'])
    ));
    exit;
  } 
   
  //process user login request
  function processLogin() {
      
    if(isUserNamePresentInTable($_POST['uname']) === false) {
      //User name not present in the database
      $data = [ 'success' => false, 
        'message' => 'Invalid Username.Please Register First' ];
      echo json_encode($data);
      exit;
    } else {
        
      //User name present in database.
      //Verify password
      $results = isValidPassword($_POST['uname'], $_POST['pwd']);
      if($results['valid'] === false) {
    
        echo json_encode(array(
          "success" => false,
          "message" => "Incorrect password"
        ));
        exit;
      } else {
         
        //User logged in
        //Create token and add it to session
        $token = bin2hex(openssl_random_pseudo_bytes(32));
        session_start();
        $_SESSION['userId'] = $results['userId'];
        $_SESSION['token'] = $token;
        echo json_encode(array(
          'success' => true
        ));
        exit;
      }
    }
  }
   
  //process user register request
  function processRegister() {
      
    if(isUserNamePresentInTable($_POST['uname']) === true) {
        
      //User already registered
      echo json_encode(array(
        "success" => false,
        "message" => "username already in use"
      ));
      exit;
    } else {
        
      //Add user to the users table
      addUser($_POST['uname'], $_POST['pwd']);
      echo json_encode(array(
        "success" => true
      ));
      exit;
    }
  }
?>