<?php 
  //If user is logged in, displays a form where user can add event details
  //otherwise displays an error message
  session_start();
  if(isset($_SESSION['token'])) {
    //User is logged in, so AddEvent form is displayed

    //User is logged in but instead of clicking on the date
    //to add event, user directly opened the url in a new window.
    //This action should not be allowed.
    if(is_null($_POST['date']) || $_POST['date'] === "0000-00-00") {
    
      echo "<script type = 'text/javascript'>";
      echo "alert('Please Click on a date in calendar to add event');";
      echo "</script>";
      return;
    } 
?>
  <!DOCTYPE HTML>
  <html>
    <head>
      <title>Add Event</title>
      <link rel='stylesheet' href='../CalendarEvents.css' />
      <script type="text/javascript" src = "http://ajax.googleapis.com/ajax/libs/jquery/1.2.6/jquery.min.js"></script>
      <script src = 'EventActions.js'></script>
    
      <script>
    
        $(document).ready(function() {
          //Get date from post request and add it to readonly date field
          $("#date").val("<?php echo htmlentities($_POST['date']); ?>");
        });
      </script>
    </head>
    <body>
    <div id = "addEventForm">
      <label>Event Date</label>
      <input type = "text" name = "date" id = "date" readonly>
      <br/><br/>
      <label>Event Title</label>
      <input type = "text" name = "title" id = "title">
      <label>Start Time</label>
      <input type = "time" name = "startTime" id = "startTime">
      <label>End Time</label>
      <input type = "time" name = "endTime" id = "endTime">
      <label>Category</label>
      <select name = "category" id = "category">
        <option value = "work" id = "none" disabled selected = "selected">None</option>
        <option value = "work">Work</option>
        <option value = "home">Home</option>
        <option value = "school">School</option>
      </select>
      <br/><br/><br/><br/><br/>
      <input type = "hidden" name = "token" id = "token" value = "<?php echo $_SESSION['token'];?>" />
      <div>
        <input type = "submit" name = "submitEvent" class = "submitEvent" id = "addEvent" Value = "Submit">
        <input type = "reset" name = "cancel" class = "cancel" id = "cancel" Value = "Cancel">
      </div>
    </div>
  </body>
</html>
<?php
  } else {
    
    //User is not logged in, display an alert message and close 
    //AddEvent window
    echo "<script>alert('Please Login first');</script>";
    echo "<script>window.close();</script>";
  }
?>