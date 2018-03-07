//JSHint configuration to ignore $ while validating the file
//Otherwise gives undefined variabe $ wherever jquery is used
/*globals $:false */

/*
 *  JS functions to handle actions related to calendar events like 
 *  add, delete, share, update, filter
*/


//Get new event details from the form and validate the input.
//If it is valid, then send ajax request to server
function addEventData() {
  
  //Get values from form
  var date = document.getElementById("date").value;
  var title = document.getElementById("title").value;
  var startTime = document.getElementById("startTime").value;
  var endTime = document.getElementById("endTime").value;
  //Validate input
  var errMessage = validateInput(title, startTime, endTime);
  if(errMessage !== "") {
    
    alert(errMessage);
    return;
  }
  //Get selected category
  var el = document.getElementById("category");
  var category = "default";
  if(el.selectedIndex !== 0)
    category = el.options[el.selectedIndex].value;
  var token = document.getElementById("token").value;
  
  //Create data to be sent in post request
  var postData = "date=" + encodeURIComponent(date) + 
      "&title=" + encodeURIComponent(title) + 
      "&startTime=" + encodeURIComponent(startTime)+ 
      "&endTime=" + encodeURIComponent(endTime)+ 
      "&action=add" +
      "&category=" + encodeURIComponent(category) + 
      "&token=" + encodeURIComponent(token);

  //Ajax request to server
  var xmlHttp = new XMLHttpRequest();
  xmlHttp.open("POST", "http://ec2-54-174-181-94.compute-1.amazonaws.com/~nathala/CalendarEvents/core/EventActions.php", true);
  
  xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");     
  xmlHttp.addEventListener("readystatechange", updateCalendarUI, false);
  xmlHttp.send(postData);
}

//validate title, start time and end time
//Title, endTime and startTime are required fields.
//Tilte length should be greater than 5 characters
//endTime should be greater than startTime
function validateInput(title, startTime, endTime) {
  
  var errMsg = "";
  if(title.length < 5) {
    errMsg += "Title should be greater than 5 charecters '\n ";
  }
  if(endTime === "" || endTime === null){
    errMsg += "Please enter proper endTime '\n";
  }
  if(startTime === "" || startTime === null){
    errMsg += "Please enter proper startTime '\n";
  }
  if(endTime <= startTime){
    errMsg += "EndTime should be greater than Start time '\n";
  }
  return errMsg;
}

//callback function for ajax request
//refreshes calendar events in parent window
//and closes child window
function updateCalendarUI(event) {
  
  opener.refetchEvents(); 
  window.close();
}

//Close the current window when user clicks on cancel button
function cancelEventAction() {
  
  window.close();
}

//Get event updates from the form and validate the input.
//If it is valid, then send ajax request to server
function updateEventAction() {

  //Get values from form
  var title = document.getElementById("title").value;
  var startTime = document.getElementById("startTime").value;
  var endTime = document.getElementById("endTime").value;
  var token = document.getElementById("token").value;
  var eventId = document.getElementById("eventId").value;
  //Validate input
  var errMessage = validateInput(title, startTime, endTime);
  if(errMessage !== "") {
    
    alert(errMessage);
    return;
  }
  //Create data to be sent in post request
  var postData = "title=" + encodeURIComponent(title) + 
      "&startTime=" + encodeURIComponent(startTime)+ 
      "&endTime=" + encodeURIComponent(endTime)+ 
      "&action=update" +
      "&eventId=" + encodeURIComponent(eventId) + 
      "&token=" + encodeURIComponent(token);
      
  //Ajax request to server
  var xmlHttp = new XMLHttpRequest();
  xmlHttp.open("POST", "http://ec2-54-174-181-94.compute-1.amazonaws.com/~nathala/CalendarEvents/core/EventActions.php", true);
  xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");     
  xmlHttp.addEventListener("readystatechange", updateCalendarUI, false);
  xmlHttp.send(postData);
}

//Send delete event ajax request to server
function deleteEventAction() {
  
  //Get eventId from form
  var eventId = document.getElementById("eventId").value;
  var token = document.getElementById("token").value;
  var postData = "eventId=" + encodeURIComponent(eventId) + 
      "&action=delete" +
      "&token=" + encodeURIComponent(token);

  //Ajax request to server
  var xmlHttp = new XMLHttpRequest();
  xmlHttp.open("POST", "http://ec2-54-174-181-94.compute-1.amazonaws.com/~nathala/CalendarEvents/core/EventActions.php", true);
  xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");     
  xmlHttp.addEventListener("readystatechange", updateCalendarUI, false);
  xmlHttp.send(postData);
}

//Display users list(checkboxes) to the logged in user and add an event handler to them
function selectUsers() {
  
  document.getElementsByClassName('users')[0].style.display = "block";
  document.getElementById("shareWithSelected").addEventListener("click", shareWithSelectedUsers, false);
}

//Get the users selected by the logged in user from the list
function getSelectedUsers() {
  
  var selected = [];
  $('.users input:checked').each(function() {
    selected.push($(this).attr('value'));
  });
  
  if(selected.length === 0) {
    //If user clicked on share without selecting any user
    //display alert message
    alert ("Please select the users you want to share with");
  }
  else {
    
    //return selected users userid as a string
    var i = 0;
    var selectedStr = ",";
    for(;i < selected.length; i++) {
      
      selectedStr += selected[i] + ",";
    }
    return selectedStr;
  }
}

//Send share event ajax request to server
function shareWithSelectedUsers() {
  
  var eventId = document.getElementById("eventId").value;
  var token = document.getElementById("token").value;
  var selected = getSelectedUsers();
  var postData = "eventId=" + encodeURIComponent(eventId) + 
      "&action=share" +
      "&token=" + encodeURIComponent(token) +
      "&users=" + encodeURIComponent(selected);

  //Ajax request to server
  var xmlHttp = new XMLHttpRequest();
  xmlHttp.open("POST", "http://ec2-54-174-181-94.compute-1.amazonaws.com/~nathala/CalendarEvents/core/EventActions.php", true);
  xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");     
  xmlHttp.addEventListener("readystatechange", updateCalendarUI, false);
  xmlHttp.send(postData);
}

//Filter events on the UI
//If user selects all, then filter logic is not applied
function filterEvents(event) {
  
  var category = $(this).attr('name');
  if(category === "all") 
    window.parent.refetchFromFrame();
  else {
    window.parent.refetchFromFrame();
    setTimeout(function(){ applyFilter(category); }, 150);
  }
}

//Function to decide which events to be filtered out
function applyFilter(category) {
  //Get calendar element
  var myCalendar = window.parent.getCalendar();
  //fullcalendar library removeEvents method handler
  //This method is called for every event that is displayed on the UI
  //If this method returns true for an event, that event is removed from the UI
  myCalendar.fullCalendar( 'removeEvents', function(calendarEvent) {

    //All shared events are displayed irrespective of the category
    if(category === "shared")
      return calendarEvent.shared !== "yes";
    else {
      //Remove all shared events
      if(calendarEvent.shared === "yes")
        return true;
      //Add only those events which have the selected category
      return calendarEvent.category !== category;
    }
  });
}

//Add event listeners to the elements in the window
//This file is used for add, edit and filter event actions
//So first check if that element is present in the window.
//If yes, then add event listener
document.addEventListener("DOMContentLoaded", function() {
  
  if(document.getElementById("addEvent"))
    document.getElementById("addEvent").addEventListener("click", addEventData, false);
  if(document.getElementById("cancel"))
    document.getElementById("cancel").addEventListener("click", cancelEventAction, false);
  if(document.getElementById("updateEvent"))
    document.getElementById("updateEvent").addEventListener("click", updateEventAction, false);
  if(document.getElementById("deleteEvent"))
    document.getElementById("deleteEvent").addEventListener("click", deleteEventAction, false);
  if(document.getElementById("shareEvent"))
    document.getElementById("shareEvent").addEventListener("click", selectUsers, false);
  if(document.getElementById("work"))
    document.getElementById("work").addEventListener("click", filterEvents, false);
  if(document.getElementById("home"))
    document.getElementById("home").addEventListener("click", filterEvents, false);
  if(document.getElementById("school"))
    document.getElementById("school").addEventListener("click", filterEvents, false);
  if(document.getElementById("shared"))
    document.getElementById("shared").addEventListener("click", filterEvents, false);
  if(document.getElementById("all"))
    document.getElementById("all").addEventListener("click", filterEvents, false);
  if(document.getElementById("noCategory"))
    document.getElementById("noCategory").addEventListener("click", filterEvents, false);
}, false);