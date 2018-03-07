/*globals angular:false */
(function () {
   'use strict';
   // this function is strict...
}());

var bingoApp = angular
  .module('bingoApp', [
    'ngRoute',
    'ngCookies',
    'ngResource',
    'ngSanitize',
    'btford.socket-io',
    'ui.bootstrap',
    'ngModal'
  ]);
  
bingoApp.run(['$rootScope', function($rootScope) {
  
    $rootScope.resetGame = false;
  }
]);