/*globals module:false */
/*globals require:false */
/*globals __dirname:false */
(function () {
   'use strict';
   // this function is strict...
}());

// define globals
var express = require('express'),
    io = require('socket.io'),
    http = require('http'),
    app = express(),
    server = http.createServer(app),
    io = io.listen(server);

// set up our socket server
require('./sockets/base')(io);

// start the server
server.listen(3000, function() {
   console.log("server listening on port 3000");
});

app.use(express.static(__dirname +  '/angular_module'));
app.use(express.static(__dirname + '/bower_components'));

/// error handlers
/*
app.use(function (req, res, next) {
 
   console.log("404 error")
   console.error(err.stack)
   res.status(500).send('Something broke!')

});
*/
/// error
app.use(function (err, req, res, next) {
   console.log("500 error");
   console.error(err.stack);
   res.status(500).send('Something broke!');
});

module.exports = app;