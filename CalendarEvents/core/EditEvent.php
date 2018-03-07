<!DOCTYPE HTML>
<?php require_once 'EventsTable.php';

  //If user is logged in, displays a edit form with event details where user can editEventForm
  //event details, otherwise displays an error message
  
  session_start();
  //User is not logged in, display an alert message 
  if(!isset($_SESSION['token'])) {
    echo "<script>alert('Illegal request');</script>";
    return;
  }
  //User is logged in but instead of clicking on the event
  //to edit it, user directly opened the url in a new window.
  //This action should not be allowed.
  if(is_null($_POST['id']) || $_POST['id'] === "") {
    
    echo "<script type = 'text/javascript'>";
    echo "alert('Please Click on the event you want to edit');";
    echo "</script>";
    return;
  } 
  $eventId = $_POST['id'];
  //Fetch event details from database
  $event = getEvent($eventId);
?>
  <html>
  <head>
    <title>Edit Event</title>
    <link rel='stylesheet' href='../CalendarEvents.css' />
    <script type="text/javascript" src = "http://ajax.googleapis.com/ajax/libs/jquery/1.2.6/jquery.min.js"></script>
    <script src = 'EventActions.js'></script>
  </head>
  <body>
    
    <div id = "editEventForm">
      <label>Event Date</label>
      <input type = "text" name = "date" id = "date" value = "<?php echo htmlentities($event[2]) ?>" readonly>
      <br/><br/>
      <label>Event Title</label>
      <input type = "text" name = "title" id = "title" value = "<?php echo htmlentities($event[1]) ?>">
      <label>Start Time</label>
      <input type = "time" name = "startTime" id = "startTime" value = "<?php echo htmlentities($event[3]) ?>">
      <label>End Time</label>
      <input type = "time" name = "endTime" id = "endTime" value = "<?php echo htmlentities($event[4]) ?>">
      <label>Category</label>
<?php
  
  if(is_null($event[5]) || $event[5] === "")
    addCategory("none");
  else
    addCategory($event[5]);
  function addCategory($category) {
    echo sprintf('<input type = "text" name = "category" id = "category" value = "%s" readonly>', htmlentities($category));
  }
?>  
    
    <br/></br></br></br></br>
    <input type = "hidden" name = "token" id = "token" value = "<?php echo $_SESSION['token'];?>" />
    <!-- eventId of the event being edited -->
    <input type = "hidden" name = "eventId" id = "eventId" value = "<?php echo htmlentities($eventId);?>" />
<?php
  //If this is an event created by the logged in user,
  //then display update, delete and share buttons
  if($event[0] === $_SESSION['userId']) 
    addButtons();
  
  function addButtons() {
    
    echo '<div>';
    echo '<input type = "submit" name = "updateEvent" class = "updateEvent" id = "updateEvent" Value = "Update">';
    echo '<input type = "submit" name = "deleteEvent" class = "deleteEvent" id = "deleteEvent" Value = "Delete">';
    echo '<input type = "submit" name = "shareEvent" class = "shareEvent" id = "shareEvent" Value = "Share">';
  }
?> 
  <!-- This is an event shared with the logged in user, which he/she can view but cannot edit.
   So, only cancel button is added to the form-->
    <input type = "submit" name = "cancel" class = "cancel" id = "cancel" Value = "Cancel"><br><br><br><br>
    </div>
    <!-- This div is displayed when user clicks on share button -->
    <div id = "none" class = "users">
      <h5>Select Users</h5>
<?php

  include_once 'UsersTable.php';
  $users = getOtherUsers($_SESSION['userId']);
  for($i = 0; $i < sizeof($users); $i++) {
    
    echo sprintf("<input type = 'checkbox' name = 'users[]' value = '%s'/>%s<br/>", htmlentities($users[$i][1]), htmlentities($users[$i][0]) );
  }
?>     
        <input type = "submit" name = "shareWithSelected" class = "shareWithSelected" id = "shareWithSelected"
            Value = "Share With Selected">
      </div>
    </div>  
  </body>
</html>

