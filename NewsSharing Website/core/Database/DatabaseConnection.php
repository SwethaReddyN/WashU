<?php
   //File to manage database connection

   function establishDBConnection() {
      
      $mySqlCon = new PDO("mysql:host=localhost;dbname=NewsShare", "swethareddy", "EcoEye+HP012;");
      return $mySqlCon;
   }
   
   function closeConnection($mySqlCon) {
      mysql_close($mySqlCon);
   }
?>