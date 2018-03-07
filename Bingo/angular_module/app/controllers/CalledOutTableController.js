/*globals $:false */
/*globals angular:false */
(function () {
   'use strict';
   // this function is strict...
}());

angular.module('bingoApp')
.controller('calledOutTableCtrl', function ($rootScope, $scope,  $window, chatSocket) {

    $scope.gridSize = 5;
    $scope.calledOutTable =
    [
    	{
      		rowNum: 0,
       		cols: [
       			{
       				colNum : 0,
       				value: 1,
       				isCalledOut : false
       			},
        		{
        			colNum : 1,
       				value: 21,
       				isCalledOut : false
       			},
       			{
       				colNum : 2,
      				value: 41,
      				isCalledOut : false
       			},
       			{
       				colNum : 3,
      				value: 61,
      				isCalledOut : false
       			},
       			{
       				colNum : 4,
      				value: 81,
      				isCalledOut : false
       			}
       		]
    	},
    	{
      		rowNum: 1,
       		cols: [
       			{
       				colNum : 0,
       				value: 2,
       				isCalledOut : false
       			},
        		{
        			colNum : 1,
       				value: 22,
       				isCalledOut : false
       			},
       			{
       				colNum : 2,
      				value: 42,
      				isCalledOut : false
       			},
       			{
       				colNum : 3,
      				value: 62,
      				isCalledOut : false
       			},
       			{
       				colNum : 4,
      				value: 82,
      				isCalledOut : false
       			}
       		]
    	},		
    	{
      		rowNum: 2,
       		cols: [
       			{
       				colNum : 0,
       				value: 3,
       				isCalledOut : false
       			},
        		{
        			colNum : 1,
       				value: 23,
       				isCalledOut : false
       			},
       			{
       				colNum : 2,
      				value: 43,
      				isCalledOut : false
       			},
       			{
       				colNum : 3,
      				value: 63,
      				isCalledOut : false
       			},
       			{
       				colNum : 4,
      				value: 83,
      				isCalledOut : false
       			}
       		]
    	},
    	{
      		rowNum: 3,
       		cols: [
       			{
       				colNum : 0,
       				value: 4,
       				isCalledOut : false
       			},
        		{
        			colNum : 1,
       				value: 24,
       				isCalledOut : false
       			},
       			{
       				colNum : 2,
      				value: 44,
      				isCalledOut : false
       			},
       			{
       				colNum : 3,
      				value: 64,
      				isCalledOut : false
       			},
       			{
       				colNum : 4,
      				value: 84,
      				isCalledOut : false
       			}
       		]
    	},
    	{
      		rowNum: 4,
       		cols: [
       			{
       				colNum : 0,
       				value: 5,
       				isCalledOut : false
       			},
        		{
        			colNum : 1,
       				value: 25,
       				isCalledOut : false
       			},
       			{
       				colNum : 2,
      				value: 45,
      				isCalledOut : false
       			},
       			{
       				colNum : 3,
      				value: 65,
      				isCalledOut : false
       			},
       			{
       				colNum : 4,
      				value: 85,
      				isCalledOut : false
       			}
       		]
    	},
		{
      		rowNum: 5,
       		cols: [
       			{
       				colNum : 0,
       				value: 6,
       				isCalledOut : false
       			},
        		{
        			colNum : 1,
       				value: 26,
       				isCalledOut : false
       			},
       			{
       				colNum : 2,
      				value: 46,
      				isCalledOut : false
       			},
       			{
       				colNum : 3,
      				value: 66,
      				isCalledOut : false
       			},
       			{
       				colNum : 4,
      				value: 86,
      				isCalledOut : false
       			}
       		]
    	},
		{
      		rowNum: 6,
       		cols: [
       			{
       				colNum : 0,
       				value: 7,
       				isCalledOut : false
       			},
        		{
        			colNum : 1,
       				value: 27,
       				isCalledOut : false
       			},
       			{
       				colNum : 2,
      				value: 47,
      				isCalledOut : false
       			},
       			{
       				colNum : 3,
      				value: 67,
      				isCalledOut : false
       			},
       			{
       				colNum : 4,
      				value: 87,
      				isCalledOut : false
       			}
       		]
    	},
		{
      		rowNum: 7,
       		cols: [
       			{
       				colNum : 0,
       				value: 8,
       				isCalledOut : false
       			},
        		{
        			colNum : 1,
       				value: 28,
       				isCalledOut : false
       			},
       			{
       				colNum : 2,
      				value: 48,
      				isCalledOut : false
       			},
       			{
       				colNum : 3,
      				value: 68,
      				isCalledOut : false
       			},
       			{
       				colNum : 4,
      				value: 88,
      				isCalledOut : false
       			}
       		]
    	},
		{
      		rowNum: 8,
       		cols: [
       			{
       				colNum : 0,
       				value: 9,
       				isCalledOut : false
       			},
        		{
        			colNum : 1,
       				value: 29,
       				isCalledOut : false
       			},
       			{
       				colNum : 2,
      				value: 49,
      				isCalledOut : false
       			},
       			{
       				colNum : 3,
      				value: 69,
      				isCalledOut : false
       			},
       			{
       				colNum : 4,
      				value: 89,
      				isCalledOut : false
       			}
       		]
    	},
		{
      		rowNum: 9,
       		cols: [
       			{
       				colNum : 0,
       				value: 10,
       				isCalledOut : false
       			},
        		{
        			colNum : 1,
       				value: 30,
       				isCalledOut : false
       			},
       			{
       				colNum : 2,
      				value: 50,
      				isCalledOut : false
       			},
       			{
       				colNum : 3,
      				value: 70,
      				isCalledOut : false
       			},
       			{
       				colNum : 4,
      				value: 90,
      				isCalledOut : false
       			}
       		]
    	},
		{
      		rowNum: 10,
       		cols: [
       			{
       				colNum : 0,
       				value: 11,
       				isCalledOut : false
       			},
        		{
        			colNum : 1,
       				value: 31,
       				isCalledOut : false
       			},
       			{
       				colNum : 2,
      				value: 51,
      				isCalledOut : false
       			},
       			{
       				colNum : 3,
      				value: 71,
      				isCalledOut : false
       			},
       			{
       				colNum : 4,
      				value: 91,
      				isCalledOut : false
       			}
       		]
    	},
		{
      		rowNum: 11,
       		cols: [
       			{
       				colNum : 0,
       				value: 12,
       				isCalledOut : false
       			},
        		{
        			colNum : 1,
       				value: 32,
       				isCalledOut : false
       			},
       			{
       				colNum : 2,
      				value: 52,
      				isCalledOut : false
       			},
       			{
       				colNum : 3,
      				value: 72,
      				isCalledOut : false
       			},
       			{
       				colNum : 4,
      				value: 92,
      				isCalledOut : false
       			}
       		]
    	},
		{
      		rowNum: 12,
       		cols: [
       			{
       				colNum : 0,
       				value: 13,
       				isCalledOut : false
       			},
        		{
        			colNum : 1,
       				value: 33,
       				isCalledOut : false
       			},
       			{
       				colNum : 2,
      				value: 53,
      				isCalledOut : false
       			},
       			{
       				colNum : 3,
      				value: 73,
      				isCalledOut : false
       			},
       			{
       				colNum : 4,
      				value: 93,
      				isCalledOut : false
       			}
       		]
    	},
		{
      		rowNum: 13,
       		cols: [
       			{
       				colNum : 0,
       				value: 14,
       				isCalledOut : false
       			},
        		{
        			colNum : 1,
       				value: 34,
       				isCalledOut : false
       			},
       			{
       				colNum : 2,
      				value: 54,
      				isCalledOut : false
       			},
       			{
       				colNum : 3,
      				value: 74,
      				isCalledOut : false
       			},
       			{
       				colNum : 4,
      				value: 94,
      				isCalledOut : false
       			}
       		]
    	},
		{
      		rowNum: 14,
       		cols: [
       			{
       				colNum : 0,
       				value: 15,
       				isCalledOut : false
       			},
        		{
        			colNum : 1,
       				value: 35,
       				isCalledOut : false
       			},
       			{
       				colNum : 2,
      				value: 55,
      				isCalledOut : false
       			},
       			{
       				colNum : 3,
      				value: 75,
      				isCalledOut : false
       			},
       			{
       				colNum : 4,
      				value: 95,
      				isCalledOut : false
       			}
       		]
    	},
		{
      		rowNum: 15,
       		cols: [
       			{
       				colNum : 0,
       				value: 16,
       				isCalledOut : false
       			},
        		{
        			colNum : 1,
       				value: 36,
       				isCalledOut : false
       			},
       			{
       				colNum : 2,
      				value: 56,
      				isCalledOut : false
       			},
       			{
       				colNum : 3,
      				value: 76,
      				isCalledOut : false
       			},
       			{
       				colNum : 4,
      				value: 96,
      				isCalledOut : false
       			}
       		]
    	},
		{
      		rowNum: 16,
       		cols: [
       			{
       				colNum : 0,
       				value: 17,
       				isCalledOut : false
       			},
        		{
        			colNum : 1,
       				value: 37,
       				isCalledOut : false
       			},
       			{
       				colNum : 2,
      				value: 57,
      				isCalledOut : false
       			},
       			{
       				colNum : 3,
      				value: 77,
      				isCalledOut : false
       			},
       			{
       				colNum : 4,
      				value: 97,
      				isCalledOut : false
       			}
       		]
    	},
		{
      		rowNum: 17,
       		cols: [
       			{
       				colNum : 0,
       				value: 18,
       				isCalledOut : false
       			},
        		{
        			colNum : 1,
       				value: 38,
       				isCalledOut : false
       			},
       			{
       				colNum : 2,
      				value: 58,
      				isCalledOut : false
       			},
       			{
       				colNum : 3,
      				value: 78,
      				isCalledOut : false
       			},
       			{
       				colNum : 4,
      				value: 98,
      				isCalledOut : false
       			}
       		]
    	},
		{
      		rowNum: 18,
       		cols: [
       			{
       				colNum : 0,
       				value: 19,
       				isCalledOut : false
       			},
        		{
        			colNum : 1,
       				value: 39,
       				isCalledOut : false
       			},
       			{
       				colNum : 2,
      				value: 59,
      				isCalledOut : false
       			},
       			{
       				colNum : 3,
      				value: 79,
      				isCalledOut : false
       			},
       			{
       				colNum : 4,
      				value: 99,
      				isCalledOut : false
       			}
       		]
    	},
		{
      		rowNum: 19,
       		cols: [
       			{
       				colNum : 0,
       				value: 20,
       				isCalledOut : false
       			},
        		{
        			colNum : 1,
       				value: 40,
       				isCalledOut : false
       			},
       			{
       				colNum : 2,
      				value: 60,
      				isCalledOut : false
       			},
       			{
       				colNum : 3,
      				value: 80,
      				isCalledOut : false
       			},
       			{
       				colNum : 4,
      				value: 100,
      				isCalledOut : false
       			}
       		]
    	},
    ];

	$scope.cancelCalledOut = function(colNum, rowNum) {
		$scope.calledOutTable[rowNum].cols[colNum].isCalledOut = true;
	};
  
  function resetTable() {
    for(var i = 0; i < 20; i++) {
      for(var k = 0; k < 5; k++) {
        $scope.calledOutTable[i].cols[k].isCalledOut = false;
      }
    }
    console.log($scope.calledOutTable);
    $rootScope.resetGame = false;
    $('#displayCalloutNumber').text("x");
  }

	chatSocket.on('callout_number', function(data) {
		var rowNum = $scope.calculateRowNum(data);
		var colNum = $scope.calculateColNum(data);
		$scope.cancelCalledOut(colNum, rowNum);
		$scope.$apply();
	  $('#displayCalloutNumber').text(data);
	});
	
	chatSocket.on('game_in_progress', function(data) {
    
    var rowNum = 0;
    var colNum;
		for(var i = 0; i < data.length; i++) {
			rowNum = $scope.calculateRowNum(data[i]);
			colNum = $scope.calculateColNum(data[i]);
			$scope.cancelCalledOut(colNum, rowNum);
		}
    $window.alert("You have joined a game in progress. Please cancel out the called out numbers from the table on right");
	});
	
	$scope.calculateRowNum = function(num) {
		if(num % 20 === 0) {
			return 19;
		}
		else {
			return parseInt(num) % 20 - 1;			
		}
	};
  
	$scope.calculateColNum = function(num) {
		if(num % 20 === 0) {
			return Math.floor(parseInt(num) / 20) - 1;
		}
		else {
			return Math.floor(parseInt(num) / 20);			
		}
	};
  
  $scope.$watch(function() {
      return $rootScope.resetGame;
    }, function() {
      if($rootScope.resetGame)
        resetTable();
    }, true);
});
