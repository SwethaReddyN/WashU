<?php require_once 'EventsTable.php';
//Processes add event, delete event, fetch all events, update
//and share event post requests from client 
  session_start();
  header('Content-Type: application/json');

  //When application tries to fetch events but the user is not logged in
  if((isset($_SESSION) && isset($_SESSION['userId'])) === false) {
    echo json_encode(array(
      'success' => true,
      'message' => 'Only logged in users can view events' 
    ));
    exit;
  }

  //Get logged in user id from session
  $userId = $_SESSION['userId'];
       
  if($_POST['action'] === 'fetchEvents') {
    //Get all the events created be logged in user
    fetchAll($_SESSION['userId']);
  } else if ($_POST['action'] === 'fetchSharedEvents') {
    //Get all the events shared with logged in user
    fetchSharedEvents($_SESSION['userId']);
  } else {
    
    //Since First page is never refreshed,
    //Whenever events are fetched, token info is not
    //present on the client side.
    //So, for add, update, delete and share event actions
    //token is checked  
    if(!hash_equals($_SESSION['token'], $_POST['token'])){
      echo "<script>alert('Token Error');</script>";
      die("Request forgery detected");
    }
    
    if($_POST['action'] === "add") {

      //Add event to the database
      $category = ($_POST['category'] !== "default") ? $_POST['category'] : null;
      addEvent($_POST['title'], $_POST['date'], $_POST['startTime'], $_POST['endTime'], 
          $category, $userId);  
      echo json_encode(array(
          'success' => true
      ));
      exit;
    } else if($_POST['action'] === 'update') {
        
        //Update event in the database
        updateEvent($_POST['eventId'], $_POST['title'], $_POST['startTime'],
            $_POST['endTime']);
        echo json_encode(array(
          'success' => true
        ));
        exit;
    } else if($_POST['action'] === 'delete') {
        //delete event from database
        deleteEvent($_POST['eventId']);
        echo json_encode(array(
          'success' => true
        ));
        exit;
    } else if($_POST['action'] === 'share') {
      
      //Share event with the users
      addSharedEvent($_POST['eventId'], $_POST['users']);
       echo json_encode(array(
          'success' => true
      ));
    } else {
      echo json_encode(array(
        'success' => false,
        'message' => 'Undefined Action'
      ));
    }
  }
  
  function fetchAll($userId) {
    if(isset($userId) === false) { 
      echo json_encode(array(
        'success' => false
      ));
      exit;
    }
    $events = fetchEvents($userId);
    if(sizeof($events[0]) === 0) {
      echo json_encode(array(
        'success' => false
      ));
      exit;
    } else {
      
      echo json_encode($events);
      exit;
    }
  }
  
  function fetchSharedEvents($userId) {
    
    if(isset($userId) === false) { 
      echo json_encode(array(
        'success' => false
      ));
      exit;
    }
    $events = fetchAllShared($userId);
    if(sizeof($events[0]) === 0) {
      echo json_encode(array(
        'success' => true
      ));
      exit;
    } else {
      
      echo json_encode($events);
      exit;
    }
  }
?>