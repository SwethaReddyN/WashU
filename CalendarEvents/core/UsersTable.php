<?php require_once 'DatabaseConnection.php';
   //File to perform mysql operations on Users table
   
   //returns true if username is present in
   //users table, otherwise false
   function isUserNamePresentInTable($uname) {
      
      $isUserPresent = false;
      try {
         $mySqlCon = establishDBConnection();
         $stmt = $mySqlCon->prepare("select * from users where username = :uname");

      if(!$stmt) { 
         printf("Query Prep Failed: %s\n", $mySqlCon->error);
         exit;
      }
 
      $stmt->bindParam(':uname', $uname, PDO::PARAM_STR);
      $stmt->execute();
      
      $row_count = $stmt->rowCount();
      if($row_count !== 0)
          $isUserPresent = true;

      return $isUserPresent;
      $stmt = null;
      $mySqlCon = null;
      } catch (PDOException $e) {
         echo 'Connection failed: ' . htmlentities($e->getMessage());
         exit();
      }
   }
   
   //Verifies hashed password with user provided pwd
   //returns true if pwd is correct, otherwise false
   function isValidPassword($uname, $pwd_guess) {
      
      $result = array();
      $validPwd = false;
      try {
         $mySqlCon = establishDBConnection();
         $stmt = $mySqlCon->prepare("select id, crypted_password from users where username = :uname");

         if(!$stmt) { 
            printf("Query Prep Failed: %s\n", $mySqlCon->error);
            exit;
         }
         
         $stmt->bindParam(':uname', $uname, PDO::PARAM_STR);
         $stmt->execute();
         $row_count = $stmt->rowCount();
         
         $stmt->bindColumn(1, $id, PDO::PARAM_INT); 
         $stmt->bindColumn(2, $pwd_hash, PDO::PARAM_STR);
   
         $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
         
         if($row_count == 1 && password_verify($pwd_guess, $pwd_hash)) {
            
            $result['valid'] = true;
            $result['userId'] = htmlentities($id);
         } else{
           
            $validPwd = false;
            $result['valid'] = false;
         }
         $rows = null;
         $stmt = null;
         $mySqlCon = null;
      } catch (PDOException $e) {
         echo 'Connection failed: ' . htmlentities($e->getMessage());
         exit();
      }
      return $result;
   }
  
  //Return users list minus the user whose userid is the argument   
  function getOtherUsers($userId) {
     
    $users = array(array());

    try {
      $mySqlCon = establishDBConnection();
      $stmt = $mySqlCon->prepare("select username, id from users where id <> :userId");
         
      if(!$stmt) { 
        printf('Query Prep Failed: %s\n', $mySqlCon->error);
        exit;
      }
      
      $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
      $stmt->execute();
      $stmt->bindColumn(1, $username, PDO::PARAM_STR);   
      $stmt->bindColumn(2, $id, PDO::PARAM_INT);         
      $row_count = $stmt->rowCount();
         
      if($row_count > 0) {
        for ($i = 0; $row = $stmt->fetch(PDO::FETCH_BOUND); $i++) {
            
          $users[$i][0] = htmlentities($username);
          $users[$i][1] = htmlentities($id);
        }
      }
      $row = null;
      $stmt = null;
      $mySqlCon = null;
    } catch (PDOException $e) {
         echo 'Connection failed: ' . htmlentities($e->getMessage());
         exit();
    }
    return $users;
  }
   //Add a new user
   function addUser($uname, $pwd) {
      
      $securePassword = getSecurePassword($pwd);
      try {
         
        $mySqlCon = establishDBConnection();
        $stmt = $mySqlCon->prepare("insert into users(username, crypted_password) values(:uname, :securePassword)");

        $stmt->bindParam(':uname', $uname, PDO::PARAM_STR);
        $stmt->bindParam(':securePassword', $securePassword, PDO::PARAM_STR);

        $stmt->execute();
         
        $stmt = null;
        $mySqlCon = null;
      } catch (PDOException $e) {
         
         echo 'Connection failed: ' . htmlentities($e->getMessage());
         exit();
      }
   }
   
   //Creates salt and uses it to create a hashed password
   function getSecurePassword($pwd) {
      
      $salt = mcrypt_create_iv(24, MCRYPT_DEV_URANDOM);
      $options = [
       'cost' => 12,
       'salt' => $salt
      ];
      return password_hash($pwd, PASSWORD_BCRYPT, $options);
   }
?>