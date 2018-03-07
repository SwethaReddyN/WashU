/*globals angular:false */
/*globals io:false */
(function () {
   'use strict';
   // this function is strict...
}());
angular.module('bingoApp')
.factory('chatSocket', function($rootScope){
    //Creating connection with server
    var chatSocket = io.connect('http://ec2-54-174-181-94.compute-1.amazonaws.com:3000');
    return chatSocket;
});