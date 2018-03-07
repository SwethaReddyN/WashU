<?php require 'Database/DatabaseConnection.php';
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
      } catch (PDOException $e) {
         echo 'Connection failed: ' . $e->getMessage();
         exit();
      }
      $mySqlCon = null;
   }
   
   //Verifies hashed password with user provided pwd
   //returns true if pwd is correct, otherwise false
   function isValidPassword($uname, $pwd_guess) {
      
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
            
            $validPwd = true;
            $GLOBALS[$userId] = $id;
         } else{
           
            $validPwd = false;
         }
         $rows = null;
      } catch (PDOException $e) {
         echo 'Connection failed: ' . $e->getMessage();
         exit();
      }
      return $validPwd;
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
         
         echo 'Connection failed: ' . $e->getMessage();
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