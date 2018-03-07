1. New Framework - 16
  Express - 10
  Integrate socketio and express - 2
  Integrate Angularjs and express - 2
  Integrate Angularjs and socket - 2
    
2. Requirements - 59
  If a user tries to log in while a game is in progress, 
    then display a message that the user is joining a game which is already in progress - 2
    server sends list of all numbers that were called out before used joined the game - 2
  Generate random numbers to populate (5 * 5) grid for logged in users (unique data for each user) - 5
  Generate random number to callout every 5 seconds and send it to all the users playing the game - 3
  Displaying 5 * 5 table of numbers to users in a table in ascending order with unique numbers - 3
  Allowing user to click a cell in grid and changing the color of selected cell to cross out the called out number - 2
  When user clicks on bingo, pause call out number generation - 5
  Other users should know that a user has clicked on bingo - 2
  Check if user cancelled out only those numbers which were called out - 5
  Check if the user has a bingo on:
    check if pattern is satisfied by row - 5
    check if pattern is satisfied by column - 5
    check if pattern is satisfied by corners - 5
  When system decides it is actually a bingo, display that info to other users - 2
  When system decides it is not a bingo, display that info to other users - 2
  Resume generating callout numbers after that - 1
  First 3 users win the game, others lose - 5
    if less than 3 users are playing the game then end the game when all get a bingo - 3
  If all the numbers are called out but no user claimed bingo, then display a message to all users and finish game. - 2  
  

4. Creative portion - 20
  A table where all the callout numbers are displayed to all users - 5
    callout table is updated for the user who joined a game which is already in progress - 5
  Check if numbers in diagonal cells got a bingo - 5
  Generate numbers in ascending order - In the first column you will see numbers from 1 to 9, in the second the numbers 10 to 19 appear, the third contains 20 to 29. 
  This pattern continues until the final column which contains the numbers 80 to 90. - 5