<?php require_once 'DatabaseConnection.php';
  //File to perform mysql operations on Events table
  
  //Add a new event
  function addEvent($title, $date, $startTime, $endTime, 
      $category, $userId) {
    
    try {
      $mySqlCon = establishDBConnection();
      $stmt = $mySqlCon->prepare("insert into Events(userId, eventTitle, eventDate, startTime, endTime, category) values(:userId, :eventTitle,
                    :eventDate, :startTime, :endTime, :category)"); 
        
      $stmt->bindParam(':category', $category, PDO::PARAM_STR);
      $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
      $stmt->bindParam(':eventTitle', $title, PDO::PARAM_STR);
      $stmt->bindParam(':eventDate', $date, PDO::PARAM_STR);
      $stmt->bindParam(':startTime', $startTime, PDO::PARAM_STR);
      $stmt->bindParam(':endTime', $endTime, PDO::PARAM_STR);
       
      $stmt->execute();
      $stmt = null;
      $mySqlCon = null;
    } catch (PDOException $e) {
        
      echo 'Connection failed: ' . htmlentities($e->getMessage());
      exit();
    }
  }
  
  //Update Event
  function updateEvent($eventId, $title, $startTime, $endTime) {
    
     try {
      $mySqlCon = establishDBConnection();
      $stmt = $mySqlCon->prepare("update Events set eventTitle = :title, startTime = :startTime, endTime = :endTime where eventId = :eventId"); 
        
      $stmt->bindParam(':title', $title, PDO::PARAM_STR);
      $stmt->bindParam(':startTime', $startTime, PDO::PARAM_STR);
      $stmt->bindParam(':endTime', $endTime, PDO::PARAM_STR);
      $stmt->bindParam(':eventId', $eventId, PDO::PARAM_INT);
      
      $stmt->execute();
      $stmt = null;
      $mySqlCon = null;
    } catch (PDOException $e) {
        
      echo 'Connection failed: ' . htmlentities($e->getMessage());
      exit();
    }
  }
  
  //Share an event with the users
  function addSharedEvent($eventId, $users) {
    
    try {
      $mySqlCon = establishDBConnection();
      $stmt = $mySqlCon->prepare("update Events set sharedWith = :sharedWith where eventId = :eventId"); 
        
      $stmt->bindParam(':sharedWith', $users, PDO::PARAM_STR);
      $stmt->bindParam(':eventId', $eventId, PDO::PARAM_INT);
      
      $stmt->execute();
      $stmt = null;
      $mySqlCon = null;
    } catch (PDOException $e) {
        
      echo 'Connection failed: ' . htmlentities($e->getMessage());
      exit();
    }
  }
  
  //delete event
  function deleteEvent($eventId) {
   
    $mySqlCon = establishDBConnection();
    $stmt = $mySqlCon->prepare("delete from Events where eventId = :eventId");
    if(!$stmt) { 
         
      echo sprintf("Query Prep Failed: %s\n", htmlentities($mySqlCon->error));
      exit;
    }
    $stmt->bindParam(':eventId', $eventId, PDO::PARAM_INT);
    $deletedRowCount = $stmt->execute();
    if($deletedRowCount === 0)
      echo 'Event not deleted';
    $mySqlCon = null;
  }
   
  //fetch all events for the user
  function fetchEvents($userId) {
    
    $events = array();

    try {
      $mySqlCon = establishDBConnection();
      $stmt = $mySqlCon->prepare("select eventId, eventTitle, eventDate, startTime, endTime, category from Events where userId = :userId");
         
      if(!$stmt) { 
        printf('Query Prep Failed: %s\n', $mySqlCon->error);
        exit;
      }
      $stmt->bindParam(':userId', $userId, PDO::PARAM_STR);
      $stmt->execute();
         
      $row_count = $stmt->rowCount();
         
      if($row_count > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            
          $e = array();
          $e['id'] = htmlentities($row['eventId']);
          $e['title'] = htmlentities($row['eventTitle']);
          $date = htmlentities($row['eventDate']);
          $e['start'] = htmlentities($date. " " . $row['startTime']);
          $e['startTime'] = htmlentities($row['startTime']);
          $e['end'] = htmlentities($date . " " . $row['endTime']);
          $e['endTime'] = htmlentities($row['endTime']);
          $e['shared'] = "no";
          $category = htmlentities($row['category']);
          if($category)
            $e['category'] = $category;
          else
            $e['category'] = "none";
          
          array_push($events, $e);
        }
      }
      $row = null;
      $stmt = null;
      $mySqlCon = null;
    } catch (PDOException $e) {
         echo 'Connection failed: ' . htmlentities($e->getMessage());
         exit();
    }
    return $events;
  }
  
  //fetch all events shared with the user
  function fetchAllShared($userId) {
    $events = array();

    try {
      $mySqlCon = establishDBConnection();
      $stmt = $mySqlCon->prepare("select eventId, eventTitle, eventDate, startTime, endTime, category from Events where sharedWith like :sharedWith");
         
      if(!$stmt) { 
        printf('Query Prep Failed: %s\n', $mySqlCon->error);
        exit;
      }
      $pattern = '%,' . $userId . ',%';
      $stmt->bindParam(':sharedWith', $pattern, PDO::PARAM_INT);
      $stmt->execute();
         
      $row_count = $stmt->rowCount();
         
      if($row_count > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            
          $e = array();
          $e['id'] = htmlentities($row['eventId']);
          $e['title'] = htmlentities($row['eventTitle']);
          $date = htmlentities($row['eventDate']);
          $e['start'] = htmlentities($date. " " . $row['startTime']);
          $e['startTime'] = htmlentities($row['startTime']);
          $e['end'] = htmlentities($date . " " . $row['endTime']);
          $e['endTime'] = htmlentities($row['endTime']);
          $e['shared'] = "yes";
          $category = htmlentities($row['category']);
          if($category)
            $e['category'] = $category;
          else
            $e['category'] = "none";
          
          array_push($events, $e);
        }
      }
      $row = null;
      $stmt = null;
      $mySqlCon = null;
    } catch (PDOException $e) {
         echo 'Connection failed: ' . htmlentities($e->getMessage());
         exit();
    }
    return $events;
  }
  
  //Fetch event details
  function getEvent($eventId) {
    
    $event = array();
    try {
      $mySqlCon = establishDBConnection();
      $stmt = $mySqlCon->prepare("select userId, eventTitle, eventDate, startTime, endTime, category from Events where eventId = :eventId");
         
      if(!$stmt) { 
        printf('Query Prep Failed: %s\n', $mySqlCon->error);
        exit;
      }
      $stmt->bindParam(':eventId', $eventId, PDO::PARAM_INT);
      $stmt->execute();
         
      $stmt->bindColumn(1, $userId, PDO::PARAM_INT); 
      $stmt->bindColumn(2, $eventTitle, PDO::PARAM_STR); 
      $stmt->bindColumn(3, $eventDate, PDO::PARAM_STR); 
      $stmt->bindColumn(4, $startTime, PDO::PARAM_STR); 
      $stmt->bindColumn(5, $endTime, PDO::PARAM_STR);
      $stmt->bindColumn(6, $category, PDO::PARAM_STR);      
      
      $row_count = $stmt->rowCount();
      if($row_count > 0) {
        
        $stmt->fetch(PDO::FETCH_BOUND);
        $event[0] = htmlentities($userId);
        $event[1] = htmlentities($eventTitle);
        $event[2] = htmlentities($eventDate);
        $event[3] = htmlentities($startTime);
        $event[4] = htmlentities($endTime);
        $event[5] = htmlentities($category);
      }
      $stmt = null;
      $mySqlCon = null;
    } catch (PDOException $e) {
         echo 'Connection failed: ' . htmlentities($e->getMessage());
         exit();
    }
    return $event;
  }
?>