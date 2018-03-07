#  **AJAX Calendar** #

- Used fullcalendar library.
- Reference : [https://fullcalendar.io/docs/usage/](Link URL)


### Calendar View ###

* fullcalendar library displays the calendar as a table grid with days as the columns and weeks as the rows, one month at a time
* fullcalendar provides a customizable event handler which allows the user to view different months as far in the past or future as desired

### User and Event Management ###

* Events can be added, modified, and deleted

    * Used mysql tables
    * Event can have a category which is assigned while adding event, this cannot be modified
     
* Events have a title, date, and time  
    * Events have a title, date, startTime and endTime. 
    * Title can be viewed in the calendar UI.
    * Event startTime and endTime is displayed as tip when the mouse hovers over the event
    
* Users can log into the site, and they cannot view or manipulate events associated with other users
    * UserId is stored in session and events are fetched using this id. So only those events which were created by the user or shared with the user are displayed to the user.
    * User can update or delete events created by them but can only view the events shared with them
* All actions are performed over AJAX, without ever needing to reload the page 
    * index.html page is never refreshed.
    * A new window is opened for adding or manipulating events. Even these pages are never refreshed, they close as soon as user clicks on a button and the calendar in index.html is updated(i.e new or updated events are displayed)
### Best Practices ###
* If storing passwords, they are stored salted and encrypted; if using OpenID, you are storing the user's OpenID identifier in the database
    * Used salted and encrypted passwords
* All AJAX requests that either contain sensitive information or modify something on the server are performed via POST, not GET
    * All the server requests are POST requests
* Safe from XSS attacks; that is, all content is escaped on output
    * passed all the output values to htmlentities function before echoing them
* Safe from SQL Injection attacks
    * Used PDO prepared queries
* CSRF tokens are passed when editing or removing events
    * tokens are passed while adding, editing, removing or sharing events
* Session cookie is HTTP-Only
    * Changed session.cookie_httponly option in php.ini, set it to 1
  ![screenshot.png](https://bitbucket.org/repo/5qxMXor/images/424955123-screenshot.png)
* Page passes the W3C validator
    * All the pages and iframe html code passed w3c validations
* Extra Credit: Your code passes JSHint or JSLint
    * Validated all js files using JSHint
           
### Creative Portion ###
            
* Events are displayed in different colors depending on the category. 3 categories - Home, School, Work; no category and shared events are displayed in different colors
* Event startTime and endTime is displayed as tip when mouse hovers over the event.
* Users can tag an event with a particular category and enable/disable those tags in the calendar UI
    * Users can filter events based on the category
* Users can share their calendar with additional users. 
    * Users can share the events they created with other users. Users with whom the events are shared can view the events but cannot edit them. When an event is deleted, even the users with whom that was shared can't view it
  

Link - 
http://ec2-54-174-181-94.compute-1.amazonaws.com/~nathala/CalendarEvents/index.html

Users Info - 
username : pwd

swethareddy : nathala1234;

tanya : reddy1234