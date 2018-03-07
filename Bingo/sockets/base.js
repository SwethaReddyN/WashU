/*globals module:false */
(function () {
   'use strict';
   // this function is strict...
}());

module.exports = function(io) {

  var timer;
  var gameStarted = false;
  var gamePaused = false;
  var timerStarted = false;
  var calledOutNumbers = [];
  var users = []; 
  var winnersCount = 0;
  var winners = [];
  
  //function to call every 3 seconds
  function generateRandomNumber() {
    
    if(calledOutNumbers.length == 100) {
      io.sockets.emit('all_num_calledout_no_winner', "");
      gameOver();
    }

    var unique = false;
    if((!gameStarted) || (gameStarted && gamePaused)) {
      
      stopRandonNumberGenerator();
    } else {
      unique = false;
      do {
        var randomNum = Math.floor(((Math.random() * 100) + 1));	
        if((calledOutNumbers.indexOf(randomNum) == -1)) {
          calledOutNumbers.push(randomNum);
          unique = true;
          io.sockets.emit('callout_number', randomNum);
          console.log(calledOutNumbers.length);
        }		
      } while(!unique);
    }
  }
  
  function stopRandonNumberGenerator() {
    
    console.log("clear timer");
    clearTimeout(timer);
    timerStarted = false;
  }
      
  function generateCallOutNumber() {

    if(!timerStarted) {
      console.log("callEvery5Sec");
      timer = setInterval(function() {
        generateRandomNumber();
        timerStarted = true;
      }, 5000);
    }
  }
  
  function checkCancelledInCalled(bingoTable) {
    
    for(var i = 0; i < bingoTable.length; i++) {
      for(var j = 0; j < bingoTable[i].rows.length; j++) {
          
        if(bingoTable[i].rows[j].isCalledOut) {
           
          if(calledOutNumbers.indexOf(bingoTable[i].rows[j].value) == -1) {
              
            console.log(bingoTable[i].rows[j].value + " not called out");
            return false;
          }
        }
      }
    }
    return true;
  }
  
  function checkRowPattern(bingoTable) {
    
    var patternFound = true;
    for(var i = 0; i < bingoTable.length; i++) {
      
      patternFound = true;
      for(var j = 0; j < bingoTable[i].rows.length; j++) {
        
        if(!bingoTable[i].rows[j].isCalledOut) {
          patternFound = false;
          break;
        }
      }
      if(patternFound) {
        console.log("pattern found row " + i);
        return true;
      }
    }
    return false;
  }
  
  function checkColumnPattern(bingoTable) {
    var patternFound = true;
    for(var i = 0; i < bingoTable.length; i++) {
      
      patternFound = true;
      for(var j = 0; j < bingoTable[i].rows.length; j++) {
        
        if(!bingoTable[j].rows[i].isCalledOut) {
          
          patternFound = false;
          break;
        }
      }
      if(patternFound) {
        console.log("pattern found column " + i);
        return true;
      }
    }
    return false;
  }
  
  function checkCornerPattern(bingoTable) {
    var length = bingoTable.length;
    if(bingoTable[0].rows[0].isCalledOut && bingoTable[0].rows[length - 1].isCalledOut &&
        bingoTable[length - 1].rows[0].isCalledOut && bingoTable[length - 1].rows[length - 1].isCalledOut) {
          
      console.log("pattern found corner ");
      return true;   
    }
    return false;
  }
  
  function checkDiagonalPattern(bingoTable) {
    var patternFound = true;
    for(var i = 0; i < bingoTable.length; i++) {
              
      if(!bingoTable[i].rows[i].isCalledOut) {
          patternFound = false;
          break;
      }
    }
    if(patternFound) {
        
      console.log("pattern found diagonal ");
      return true;
    }
    patternFound = true;
    for(i = 0; i < bingoTable.length; i++) {
              
      if(!bingoTable[i].rows[bingoTable.length - 1 - i].isCalledOut) {
          patternFound = false;
          break;
      }
    }
    if(patternFound) {
        
      console.log("pattern found diagonal ");
      return true;
    }
    return false;
  }
  
  function checkBingoPattern(bingoTable) {
  
    if(checkRowPattern(bingoTable))  {
      return true;
    } else if(checkColumnPattern(bingoTable))
      return true;
    else if(checkCornerPattern(bingoTable))
      return true;
    else if(checkDiagonalPattern(bingoTable))
      return true;
    return false;
  }
  
  function wrongClaim() {
    io.sockets.emit('wrong_claim', "");
    gamePaused = false;
    generateCallOutNumber();
  }
  
  function alreadyThreeWinners() {
    io.sockets.emit('already_three_winners', "");
    stopRandonNumberGenerator();
    gameOver();
  }
  
  function allThePlayesrWon() {
    io.sockets.emit('all_the_players_won', "");
    stopRandonNumberGenerator();
    gameOver();
  }
  
  function gameOver() {
    stopRandonNumberGenerator();
    gamePaused = false;
    calledOutNumbers = [];
    winnersCount = 0;
    winners = [];
    gameStarted = true;
    generateCallOutNumber();  
  }
  
  io.on('connection', function (socket) {  

    socket.on('user_name', function(data){
      
      if(users.indexOf(data.uname) !== -1) {
        socket.emit('username_already_taken', {uname:data.uname});
        return;
      }
      users.push(data.uname);
      console.log(users.length);
      if(gameStarted === true) {
        socket.emit('game_in_progress', calledOutNumbers);
      }
      else {
        gameStarted = true;
        generateCallOutNumber();        
      }
    });
    
    socket.on('claim_bingo', function(data) {
      
      if(winners.indexOf(data.uname) !== -1) {
        socket.emit('already_got_bingo', {uname:data.uname});
        return;
      }
      gamePaused = true;
      stopRandonNumberGenerator();
      io.sockets.emit('user_claimed_bingo_message', data.uname);
      
      var correctClaim = true;
      if(checkCancelledInCalled(data.table)) {
        
        if(!checkBingoPattern(data.table))
          correctClaim = false;
      } else {
        correctClaim = false;
      }
      if(correctClaim) {
        winnersCount++;
        winners.push(data.uname);
        io.sockets.emit('correct_claim', data.uname);
        if(users.length < 3 ) {
          if(winnersCount == users.length) {
            allThePlayesrWon();
            return;
          }
        } else if(winnersCount == 3) {
          alreadyThreeWinners();
          return;
        }
        gamePaused = false;
        generateCallOutNumber();
      }
      else {
        wrongClaim();
      }
    });
  });
};