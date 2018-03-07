<?php require_once 'Database/DatabaseConnection.php';
   //File to perform mysql operations on Comments table
   
   //Get all comments and details for an article articleId
   function getComments($articleId) {
      
      $results = array(array());
      
      try {
         $mySqlCon = establishDBConnection();
         $stmt = $mySqlCon->prepare("select userId, commenttext, commentId from comments where articleId = :articleId");
         
         if(!$stmt) { 
            printf('Query Prep Failed: %s\n', $mySqlCon->error);
            exit;
         }
         $stmt->bindParam(':articleId', $articleId, PDO::PARAM_INT);
         
         $stmt->execute();
      
         $stmt->bindColumn(1, $userId, PDO::PARAM_INT); 
         $stmt->bindColumn(2, $commenttext, PDO::PARAM_STR);
         $stmt->bindColumn(3, $commentId, PDO::PARAM_INT);
   
         $row_count = $stmt->rowCount();
         
         if($row_count > 0) {
            for ($i = 0; $row = $stmt->fetch(PDO::FETCH_BOUND); $i++) {
            
               $results[$i][0] = $userId;
               $results[$i][1] = $commenttext;
               $results[$i][2] = $commentId;
            }
         }
      } catch (PDOException $e) {
         echo 'Connection failed: ' . $e->getMessage();
         exit();
      }
      $mySqlCon = null;
      return $results;
   }
   
   //Get all commentIds for an article articleId
   function getCommentIdsForArticle($articleId) {
      
      $results = array();
      
      try {
         $mySqlCon = establishDBConnection();
         $stmt = $mySqlCon->prepare("select commentId from comments where articleId = :articleId");
         
         if(!$stmt) { 
            printf('Query Prep Failed: %s\n', $mySqlCon->error);
            exit;
         }
         $stmt->bindParam(':articleId', $articleId, PDO::PARAM_INT);
         
         $stmt->execute();
      
         $stmt->bindColumn(1, $commentId, PDO::PARAM_INT); 
   
         $row_count = $stmt->rowCount();
         
         if($row_count > 0) {
            for ($i = 0; $row = $stmt->fetch(PDO::FETCH_BOUND); $i++) {
            
               $results[$i] = $commentId;
            }
         }
      } catch (PDOException $e) {
         echo 'Connection failed: ' . $e->getMessage();
         exit();
      }
      $mySqlCon = null;
      return $results;
   }
   
   //Insert a comment into comments table for article with articleId
   //and for user userId
   function addComment($userId, $articleId, $text) {
      
       try {
         
         $mySqlCon = establishDBConnection();
         $stmt = $mySqlCon->prepare("insert into comments(userId, articleId, commenttext) values(:userId, :articleId, :text)");

         $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
         $stmt->bindParam(':articleId', $articleId, PDO::PARAM_INT);
         $stmt->bindParam(':text', $text, PDO::PARAM_LOB);
         $stmt->execute();
         $stmt = null;
         $mySqlCon = null;
      } catch (PDOException $e) {
         
         echo 'Connection failed: ' . $e->getMessage();
         exit();
      }
   }
   
   //Delete a comment with commentId from comments table
   function deleteComment($commentId) {
      
      $mySqlCon = establishDBConnection();
      $stmt = $mySqlCon->prepare("delete from comments where commentId = :commentId");
      if(!$stmt) { 
         
         printf("Query Prep Failed: %s\n", $mySqlCon->error);
         exit;
      }
      $stmt->bindParam(':commentId', $commentId, PDO::PARAM_INT);
      $deletedRowCount = $stmt->execute();
      if($deletedRowCount === 0)
         echo 'article not deleted';
      $mySqlCon = null;
      return $results;
   }
   
   //Delete all comments for an article from comments table
   function deleteAllCommentsForArticle($articleId) {
      
      $results = getCommentIdsForArticle($articleId);
      for($i = 0; $i < sizeof($results); $i++) {
         
         deleteComment($results[$i]);
      }
   }
   
   //update a comment
   function updateComment($commentId, $commentText) {
      
      try {
         $mySqlCon = establishDBConnection();
         $stmt = $mySqlCon->prepare("update comments set commenttext = :text where commentId = :commentId");
         if(!$stmt) { 
            
            printf("Query Prep Failed: %s\n", $mySqlCon->error);
            exit;
         }
         $stmt->bindParam(':text', $commentText, PDO::PARAM_LOB);
         $stmt->bindParam(':commentId', $commentId, PDO::PARAM_INT);
      
         $stmt->execute();
         $mySqlCon = null;
         return $results;
      } catch (PDOException $e) {
         
         echo 'Connection failed: ' . $e->getMessage();
         exit();
      }
   }
?>