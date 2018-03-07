//JSHint configuration to ignore $ while validating the file
//Otherwise gives undefined variabe $ wherever jquery is used
/*globals $:false */


//Initialize calendar, event sources, event handlers
// and events using fullcalendar library

var addChildWindow; //Window Handle for AddEvent operation
var editChildWindow;//Window Handle for AddEvent operation

$(document).ready(function() {
    
  // page is now ready, initialize the calendar...
  //reference : https://fullcalendar.io/docs/usage/
  $('#calendar').fullCalendar({
        
    //fullcalendar library fetches the events from
    //eventSources. There are 2 event sources.
    //First one for the events that user created
    //Second one for the events that were shared to the user  
    eventSources: [
      {
        url: 'core/EventActions.php',
        type: 'POST',
        data: {
          action: 'fetchEvents'
        },
        error: function() {
          //Error Handling function when fetching events fails
          alert('there was an error while fetching events!');
        }
      },
      {
        url: 'core/EventActions.php',
        type: 'POST',
        data: {
          action: 'fetchSharedEvents'
        },
        error: function() {
          //Error Handling function when fetching shared events fails
          alert('there was an error while fetching shared events!');
        },
        color: '#1cc184'
      }
    ],
    eventRender: function (event, element) {
      //Render the events on the UI after fetching them    
      renderCalendarEvents(event, element);
    },
    //Handles click on a date on UI event
    dayClick: function(date) {
      //convert fullcalendar date format to mysql date format
      var tokens = date.toString().split(" ");
      var month = new Date(Date.parse(tokens[1] + " 1, 2017")).getMonth() + 1;
      var dateVal = tokens[3] + "-" + month + "-" + tokens[2];
      //Open AddEvent form in a new window               
      addChildWindow = postRequestInNewWindow("core/AddEvent.php", 
              "AddEvent", ["date"], [dateVal]);
    },
    //Handles click on a calendar event on UI event
    eventClick: function(calEvent, jsEvent, view) {
      //Open Edit Event form in a new window
      editChildWindow = postRequestInNewWindow("core/EditEvent.php", 
              "EditEvent", ["id"], [calEvent.id]);
    }
  });
});

//Display Events on UI    
function renderCalendarEvents(event, element) {

  //Events are displayed in different colors based on
  //whether they are shared or not, and their categories
  if(event.shared === "yes") {
    //shared events
    element.css('background-color', '#1cc184');
    element.css('textColor', 'white');
  } else {
    if(event.category === "home") {
      //Home Events
      element.css('background-color', '#395992');
      element.css('textColor', 'white');
    } else if(event.category === "work") {
      //Work Events
      element.css('background-color', '#470715');
      element.css('textColor', 'white');
    } else if(event.category === "school") {
      //School Events
      element.css('background-color', '#c11c59');
      element.css('textColor', 'white');
    } else if(event.category === "none") {
      //No Category 
      element.css('background-color', '#c3cf20');
      element.css('textColor', '#000000');
    }
  }
  //Start time and End time are displayed as tip
  //when the mouse hovers on the event
  element.qtip({
    content: event.startTime + " to " + event.endTime
  });
  //Removed time data from Event view and displayed as
  //tip content
  element.find('.fc-time').html("");
  //Title of the Event
  element.find('.fc-title').html(event.title);
}

//Remove all events from UI, refetch from database and
//render them on UI
function refetchEvents() {
  //Remove all the events from UI
  $('#calendar').fullCalendar( 'removeEvents' );
  //Fetch events from all the eventsources and display
  $('#calendar').fullCalendar( 'refetchEvents' );
}
   
//Method is called from IFrame when user logs in 
//or logs out
window.refetchFromFrame = function () {
  
  refetchEvents();
  closeChildWindows();
};
       
//Returns calendar element       
window.getCalendar = function() {
  return $('#calendar');
};
    
//method to send post request from another window
//reference : http://stackoverflow.com/questions/5684303/javascript-window-open-pass-values-using-post
function postRequestInNewWindow(actionUrl, windowName, postDataKeys, postDataValues) {
    
  var mapForm = document.createElement("form");
  var milliseconds = new Date().getTime();
  windowName = windowName + milliseconds;
  mapForm.target = windowName;
  mapForm.method = "POST";
  mapForm.action = actionUrl;
  if(postDataKeys && postDataValues && (postDataKeys.length == postDataValues.length)) {
    for (var i = 0; i < postDataKeys.length; i++) {
          
      var mapInput = document.createElement("input");
      mapInput.type = "hidden";
      mapInput.name = postDataKeys[i];
      mapInput.value = postDataValues[i];
      mapForm.appendChild(mapInput);
    }
    document.body.appendChild(mapForm);
  }
  var windowHandle = window.open('', windowName, '');
  mapForm.submit();
  return windowHandle;
}

//Check if any child window is open
//and close them 
function closeChildWindows() {
  if (addChildWindow && !addChildWindow.closed) {
    addChildWindow.close();
  }
  if (editChildWindow && !editChildWindow.closed) {
    editChildWindow.close();
  }
}
    
//window unload event handler
window.onunload = function() {
  closeChildWindows();
};