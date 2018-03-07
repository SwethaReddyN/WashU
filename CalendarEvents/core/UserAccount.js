
/*
 *  JS functions to handle actions related to user account like 
 *  user login, user logout and register
*/

//Reset all the text fields in the page
function resetForm() {
  document.getElementById("uname").value = "";
  document.getElementById("pwd").value = "";
}

//Send logout ajax resquest to server and add callback function - displayLoginPage
function logoutForm() {
  
  var xmlHttp = new XMLHttpRequest();
  xmlHttp.open("POST", "http://ec2-54-174-181-94.compute-1.amazonaws.com/~nathala/CalendarEvents/core/AccountActions.php", true); 
  var userAction = "logout";
  var postData = "action=" + encodeURIComponent(userAction);
  xmlHttp.addEventListener("readystatechange", displayLoginPage, false);
  xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");     
  xmlHttp.send(postData);
}

//Validate username and pwd
//usernames length should be between 5 and 16
//password length should be between 8 and 16
//Both username and password can contain only
//alphanumeric characters, hyphen and underscore.
function validateInput(uname, pwd) {
  
  if(!uname)
    return "Please enter a username";
  if(!pwd)
    return "Please enter password";
  var unamePattern = /[a-zA-Z0-9_-]{5,16}/g;
  var pwdPattern = /[a-zA-Z0-9_-]{8,16}/g;
  var result = unamePattern.test(uname);
  var result2 = pwdPattern.test(pwd);
  var errMessage = "";
  if (!result) {
    errMessage += "Username can take only Uppercase letters,Lowercase letters," +
          "Numbers,hipen and Underscores and should be a mininum of 6 charecters '\n";
  } 
  if(!result2){
    errMessage += "Password can take only Uppercase letters,Lowercase letters," + 
        "Numbers,hipen and Underscores and should be a mininum of 6 charecters '\n";
  }
  return errMessage;
}

//Send login or register ajax request to server if user input is valid 
//and add callback functions
//for login resquest - displayFilterPage
//for register request - displayLoginPage
function submitForm() {
      
  var uname = document.getElementById("uname").value;
  var pwd = document.getElementById("pwd").value;
  
  var errMessage = validateInput(uname, pwd);
  if(errMessage !== "") {
    
    alert(errMessage);
    return;
  }
  
  var xmlHttp = new XMLHttpRequest(); 
  var userAction = "", postData = "";
  
  xmlHttp.open("POST", "http://ec2-54-174-181-94.compute-1.amazonaws.com/~nathala/CalendarEvents/core/AccountActions.php", true);   
  if(document.getElementById('login')) {
    userAction = "login";
    xmlHttp.addEventListener("readystatechange", displayFilterPage, false);
  }
  
  if(document.getElementById('register')) {
    userAction = "register";
    xmlHttp.addEventListener("readystatechange", displayLoginPage, false);
  }
    
  postData = "uname=" + encodeURIComponent(uname) + 
      "&pwd=" + encodeURIComponent(pwd) + 
      "&action=" + encodeURIComponent(userAction);   
  
  xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");     
  xmlHttp.send(postData);
}

//process ajax response and display filter page if success response
//is received
function displayFilterPage(event) {
  
  var jsonData = JSON.parse(event.target.responseText); 
  if(jsonData.success){  
    top.document.getElementById("contentFrame").src = 'core/Filter.html';
    reloadCalendar(event);
  } else{
    alert("You were not logged in.  " + jsonData.message);
  }
}

//process ajax response and display login page if success response
//is received
function displayLoginPage(event) {
  
  var jsonData = JSON.parse(event.target.responseText); 
  if(jsonData.success){  
    top.document.getElementById("contentFrame").src = 'core/Login.php';
    reloadCalendar(event);
  } else{
    alert("Error - " + jsonData.message);
  }
}

//refetch events from eventsources(database) and rerender them on UI
//Events are displayed if user is logging in
//If user logs out, then all the events are removed
function reloadCalendar(event) {
  
  window.parent.refetchFromFrame(); 
}

//Add event listeners to the elements in the window
//This file is used for login, logout and register account actions
//So first check if that element is present in the window.
//If yes, then add event listener
document.addEventListener("DOMContentLoaded", function() {
  if(document.getElementById("login"))
    document.getElementById("login").addEventListener("click", submitForm, false);
  if(document.getElementById("register"))
    document.getElementById("register").addEventListener("click", submitForm, false);
  if(document.getElementById("reset"))
    document.getElementById("reset").addEventListener("click", resetForm, false);
  if(document.getElementById("logout"))
    document.getElementById("logout").addEventListener("click", logoutForm, false);
}, false);