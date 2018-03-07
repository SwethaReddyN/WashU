/*globals $:false */
/*globals angular:false */
(function () {
   'use strict';
   // this function is strict...
}());

angular.module('bingoApp')
.controller('tableCtrl', function ($rootScope, $scope, $window, chatSocket) {

    $scope.gridSize = 5;
    $scope.bingo =
    [
    	{
      		colNum: 0,
       		rows: [
       			{
       				rowNum : 0,
       				value: 0,
       				isCalledOut : false
       			},
        		{
        			rowNum : 1,
       				value: 1,
       				isCalledOut : false
       			},
       			{
       				rowNum : 2,
      				value: 2, // 1 to 20
      				isCalledOut : false
       			},
       			{
       				rowNum : 3,
      				value: 3, // 1 to 20
      				isCalledOut : false
       			},
       			{
       				rowNum : 4,
      				value: 4, // 1 to 20
      				isCalledOut : false
       			}
       		]
    	},
     	{
        	colNum: 1,
        	rows: [
        		{
        			rowNum : 0,
       				value: 0, // 21 to 40
       				isCalledOut : false
        		},
        		{
        			rowNum : 1,
       				value: 1,
       				isCalledOut : false
        		},
        		{
        			rowNum : 2,
       				value: 2,
       				isCalledOut : false
        		},
        		{
        			rowNum : 3,
       				value: 3,
       				isCalledOut : false
        		},
        		{
        			rowNum : 4,
       				value: 4,
       				isCalledOut : false
        		}
        	]
        },
        {
        	colNum: 2,
        	rows: [
        		{
        			rowNum : 0,
       				value: 0, // 41 to 60
       				isCalledOut : false
        		},
        		{
        			rowNum : 1,
       				value: 1,
       				isCalledOut : false
        		},
        		{
        			rowNum : 2,
       				value: 2,
       				isCalledOut : false
        		},
        		{
        			rowNum : 3,
       				value: 3,
       				isCalledOut : false
        		},
        		{
        			rowNum : 4,
       				value: 4,
       				isCalledOut : false
        		}
        	]
        },
        {
        	colNum: 3,
        	rows: [
        		{
        			rowNum : 0,
       				value: Math.floor(Math.random() * 20) + 61, // 61 to 80
       				isCalledOut : false
       			},
       			{
       				rowNum : 1,
       				value: 1,
       				isCalledOut : false
       			},
       			{
       				rowNum : 2,
       				value: 2,
       				isCalledOut : false
       			},
       			{
       				rowNum : 3,
       				value: 3,
       				isCalledOut : false
       			},
       			{
       				rowNum : 4,
       				value: 4,
       				isCalledOut : false
       			}
        	]
        },
        {
        	colNum: 4,
        	rows: [
        		{
        			rowNum : 0,
       				value: 0,
       				isCalledOut : false
        		},
        		{
        			rowNum : 1,
       				value: 1,
       				isCalledOut : false
        		},
        		{
        			rowNum : 2,
       				value: 2,
       				isCalledOut : false
        		},
        		{
        			rowNum : 3,
       				value: 3,
       				isCalledOut : false
        		},
        		{
        			rowNum : 4,
       				value: 4,
       				isCalledOut : false
        		}
        	]
        }
    ];
	
  function sortNumber(a,b) {
    return a - b;
}

	function createRandArr(len) {
    var arr = [];
    var rowColumnData = new Array($scope.gridSize);
    for (var i = 0; i < $scope.gridSize; i++) {
      rowColumnData[i] = new Array($scope.gridSize);
    }
    for(i = 0; i < $scope.bingo.length; i++) {
			var range = len / $scope.gridSize;
			for(var j = 0; j < $scope.bingo[i].rows.length; j++) {
				var unique = false;
        var min = ((j * range) + 1);
				do {
					var randTemp = Math.floor(((Math.random() * range) + min));											
					if((arr.indexOf(randTemp) == -1)) {
						unique = true;
						arr.push(randTemp);    
            rowColumnData[j][i] = randTemp;
					}
				}
				while(!unique);
			}
    }
    for(i = 0; i < $scope.gridSize; i++) {
      rowColumnData[i].sort(sortNumber);
    }
    
    for(i = 0; i < $scope.gridSize; i++) {
      for(var k = 0; k < $scope.gridSize; k++) {
        $scope.bingo[i].rows[k].value = rowColumnData[k][i];
        $scope.bingo[i].rows[k].isCalledOut = false;
      }
    }
  }
  
  $scope.randNums = createRandArr(100);
  
  function resetBingoTable() {
    $scope.randNums = createRandArr(100);
    $rootScope.resetGame = true;
    $scope.$apply();
  }
  
  chatSocket.on('user_claimed_bingo_message', function(data) {
    
    $window.alert('A player has claimed bingo, game is paused');
  });
  
  chatSocket.on('wrong_claim', function() {
    
    $window.alert('Wrong claim');
  });
  
  chatSocket.on('already_three_winners', function() {
    $window.alert("Three players won, Game Over!");
    resetBingoTable();
  });
  
  chatSocket.on('correct_claim', function(playerWhoGotBingo) {
    
    var currentUser = $('#name').text();
    if(currentUser === playerWhoGotBingo)
      $window.alert('Congratulations!!!!, You win');
    else
      $window.alert('A player got a bingo');
  });
  
  chatSocket.on('already_got_bingo', function(playerWhoGotBingo) {
    
    $window.alert('You already got a bingo');
  });
  
  chatSocket.on('all_the_players_won', function() {
    
    $window.alert("All the players won, Game Over!");
    resetBingoTable();
  });
  
  chatSocket.on('all_num_calledout_no_winner', function() {
    $window.alert("Game Over!! All numbers have been calledout but we don't have a winner");
    resetBingoTable();
  });
  
  $scope.changeColor = function(colNum, rowNum) {
    $scope.bingo[colNum].rows[rowNum].isCalledOut = !$scope.bingo[colNum].rows[rowNum].isCalledOut;
  }; 
  
  $scope.claimBingo = function() {
    
    chatSocket.emit('claim_bingo', {table: $scope.bingo, uname : $('#name').text()} );
  };
});
