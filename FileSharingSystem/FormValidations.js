function validateUsername() {
  
  //validate username length and if it contains special characters.
  //-_ special characters are allowed.
  var uname = document.forms["usernameForm"]["uname"].value;
  
  if(uname.length < 4) {
    
    alert("User name is not valid. Minimum length of User name is 4"); 
    return false;
  } else if(uname.length >= 10) {
  
    alert("User name is not valid. Maximum length of User name is 10"); 
    return false;
  } else if(verifyIfSpecialCharsPresent(uname) == true) {
    
    alert("Your user name is not valid. Only characters A-Z, a-z, numbers 0-9 '-' '_' are acceptable.");
    return false;
  } 
  return true;
}

var specialChars = "<>@!#$%^&*()+[]{}?:;|'\"\\,./~`=";
function verifyIfSpecialCharsPresent(uname) {

  for(i = 0; i < specialChars.length;i++) {
    if(uname.indexOf(specialChars[i]) > -1) {
      return true;
    }
  }
  return false;
}
