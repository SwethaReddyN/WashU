/*globals angular:false */
(function () {
   'use strict';
   // this function is strict...
}());

angular.module('bingoApp')
.controller('loginCtrl', function ($scope, $window, chatSocket) {
  //console.log("client socket in another controller");
  $scope.modalShown = true;
  $scope.validName = false;
  $scope.player = {};
  $scope.uname = "";

  $scope.save = function(){
    $scope.uname = $scope.player.uname;
    $scope.modalShown = false;
    chatSocket.emit('user_name', {uname : $scope.player.uname});
  };
    
  $scope.change = function() {
      
     var username = $scope.player.uname;
     if(username && username.length > 0)
       $scope.validName = true;
     else
       $scope.validName = false;
  };

  $scope.hitEnter = function(evt){
    if(angular.equals(evt.keyCode,13) && $scope.validName)
      $scope.save();
  }; 
  
  $scope.cancel = function() {

    $scope.modalShown = false;
    if($scope.uname)
        return;
    $scope.uname = 'anonym_' + Math.floor(Date.now() / 1000);
    $window.alert('username is required, your name is ' +  $scope.uname);
    $scope.$apply();
    
  };
  
  chatSocket.on('username_already_taken', function(data) {
   
    $scope.uname = data.uname + '_' + Math.floor(Date.now() / 1000);
    $window.alert('username already taken, your name is ' + $scope.uname);
    $scope.$apply();
  });
});
