<?php require_once 'Database/DatabaseConnection.php';
   //File to perform mysql operations on Articles table
   
   //Get latest news : Context = "all" or "my news"
   //If context is my news, then only those stories that the user with
   //userId submitted will be returned.
   //Otherwise all news will be returned
   function getLatestNews($context, $userId) {
      
      $results = array(array());

      try {
         $mySqlCon = establishDBConnection();
         $stmt = prepareStmtForContext($mySqlCon, $context, $userId);
         
         if(!$stmt) { 
            printf('Query Prep Failed: %s\n', $mySqlCon->error);
            exit;
         }
 
         $stmt->execute();
      
         $stmt->bindColumn(1, $articleId, PDO::PARAM_INT); 
         $stmt->bindColumn(2, $title, PDO::PARAM_STR);
         $stmt->bindColumn(3, $url, PDO::PARAM_STR);
         $stmt->bindColumn(4, $text, PDO::PARAM_LOB);
         $stmt->bindColumn(5, $ownerId, PDO::PARAM_INT);
         
         
   
         $row_count = $stmt->rowCount();
         
         if($row_count > 0) {
            for ($i = 0; $row = $stmt->fetch(PDO::FETCH_BOUND); $i++) {
            
               $results[$i][0] = $articleId;
               $results[$i][1] = $title;
               $results[$i][2] = $url;
               $results[$i][3] = $text;
               $results[$i][4] = $ownerId;
            }
         }
      } catch (PDOException $e) {
         echo 'Connection failed: ' . $e->getMessage();
         exit();
      }
      $mySqlCon = null;
      return $results;
   }
   
   //Returns all latest news for category(ies)
   function getNewsByCategory($category) {
      
      $results = array(array());

      try {
         
         $mySqlCon = establishDBConnection();
         
         $inQuery = implode(',', array_fill(0, count($category), '?'));

         $stmt = $mySqlCon->prepare('select articleId, title, url, text, userId from articles where category in(' .  $inQuery . ')');
         
         if(!$stmt) { 
            printf('Query Prep Failed: %s\n', $mySqlCon->error);
            exit;
         }
   
         foreach ($category as $k => $id)
            $stmt->bindValue(($k + 1), $id);
            
         $stmt->execute();
      
         $stmt->bindColumn(1, $articleId, PDO::PARAM_INT); 
         $stmt->bindColumn(2, $title, PDO::PARAM_STR);
         $stmt->bindColumn(3, $url, PDO::PARAM_STR);
         $stmt->bindColumn(4, $text, PDO::PARAM_LOB);
         $stmt->bindColumn(3, $userId, PDO::PARAM_INT);
   
         $row_count = $stmt->rowCount();
         
         if($row_count > 0) {
            for ($i = 0; $row = $stmt->fetch(PDO::FETCH_BOUND); $i++) {
            
               $results[$i][0] = $articleId;
               $results[$i][1] = $title;
               $results[$i][2] = $url;
               $results[$i][3] = $text;
               $results[$i][4] = $ownerId;
            }
         }
      } catch (PDOException $e) {
         echo 'Connection failed: ' . $e->getMessage();
         exit();
      }
      $mySqlCon = null;
      return $results;
   }
   
   //Prepare sql statement based on context.
   //Context = "all" or "my news"
   //If context is my news, then only those stories that the user with
   //userId submitted will be returned.
   //Otherwise all news will be returned
   function prepareStmtForContext($mySqlCon, $context, $userId) {
      
      $stmt = null;
      try {
         
         if($context === "myposts") {
            $stmt = $mySqlCon->prepare("select articleId, title, url, text, userId from articles where userId = :userId");
            
            if(!$stmt) { 
               printf("Query Prep Failed: %s\n", $mySqlCon->error);
               exit;
            }
            $stmt->bindParam(':userId', $userId, PDO::PARAM_STR);
         } else {
            
            $stmt = $mySqlCon->prepare("select articleId, title, url, text, userId from articles");
         }
      } catch (PDOException $e) {
         
         echo 'Connection failed: ' . $e->getMessage();
         exit();
      }
      return $stmt;
   }
   
   //Insert a new article into articles table
   function addArticle($userId, $title, $text, $url, $category) {
      
      try {
         
         $mySqlCon = establishDBConnection();
         $stmt = $mySqlCon->prepare("insert into articles(userId, title, text, url, category) values(:userId, :title, :text, :url, :category)");
         $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
         $stmt->bindParam(':title', $title, PDO::PARAM_STR);
         $stmt->bindParam(':text', $text, PDO::PARAM_LOB);
         $stmt->bindParam(':url', $url, PDO::PARAM_STR);
         $stmt->bindParam(':category', $category, PDO::PARAM_STR);
         $result = $stmt->execute();
         $stmt = null;
         $mySqlCon = null;
      } catch (PDOException $e) {
         
         echo 'Connection failed: ' . $e->getMessage();
         exit();
      }
   }
   
   //Update article with articleId in articles table
   function updateArticle($articleId, $title, $text, $url, $category) {
      
      try {
         
         $mySqlCon = establishDBConnection();
         $stmt = $mySqlCon->prepare("update articles set title = :title, text = :text, url = :url, category = :category where articleId = :articleId");

         if(strcasecmp ($category, "none") === 0)
            $category = null;
            
         $stmt->bindParam(':title', $title, PDO::PARAM_STR);
         $stmt->bindParam(':text', $text, PDO::PARAM_LOB);
         $stmt->bindParam(':url', $url, PDO::PARAM_STR);
         $stmt->bindParam(':category', $category, PDO::PARAM_STR);
         $stmt->bindParam(':articleId', $articleId, PDO::PARAM_STR);
      
         $stmt->execute();
         $stmt = null;
         $mySqlCon = null;
      } catch (PDOException $e) {
         
         echo 'Connection failed: ' . $e->getMessage();
         exit();
      }
   }
   
   //Get article details with articleId from articles table
   function getArticle($articleId) {
      
      $results = array();
      
      $mySqlCon = establishDBConnection();
      $stmt = $mySqlCon->prepare("select title, url, text, userId, category from articles where articleId = :articleId");
      if(!$stmt) { 
         
         printf("Query Prep Failed: %s\n", $mySqlCon->error);
         exit;
      }
      $stmt->bindParam(':articleId', $articleId, PDO::PARAM_INT);
      $stmt->execute();
      
      $stmt->bindColumn(1, $title, PDO::PARAM_STR); 
      $stmt->bindColumn(2, $url, PDO::PARAM_STR);
      $stmt->bindColumn(3, $text, PDO::PARAM_LOB);
      $stmt->bindColumn(4, $userId, PDO::PARAM_INT);
      $stmt->bindColumn(5, $category, PDO::PARAM_STR);
      
      $row_count = $stmt->rowCount();
      if($row_count > 0) {
            
         $stmt->fetch(PDO::FETCH_BOUND);
         $results[0] = $title;
         $results[1] = $url;
         $results[2] = $text;
         $results[3] = $userId;
         $results[4] = $category;
      }
      $mySqlCon = null;
      return $results;
   }
   
   //delete article with articleId from articles table
   function deleteArticle($articleId) {
   
      $mySqlCon = establishDBConnection();
      include_once "CommentsTable.php";
      
      deleteAllCommentsForArticle($articleId);
      
      $stmt = $mySqlCon->prepare("delete from articles where articleId = :articleId");
      if(!$stmt) { 
         
         printf("Query Prep Failed: %s\n", $mySqlCon->error);
         exit;
      }
      $stmt->bindParam(':articleId', $articleId, PDO::PARAM_INT);
      $deletedRowCount = $stmt->execute();
      if($deletedRowCount === 0)
         echo 'Story not deleted';
      $mySqlCon = null;
      return $results;
   }
?>