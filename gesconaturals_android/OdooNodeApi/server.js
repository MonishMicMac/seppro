var http = require('http');

var server = http.createServer(function (request, response) {  
  response.writeHead(200, {"Content-Type": "text/html"});
  response.end("<h3>Node webserver running</h3>\n");
});

server.listen(8080);
console.log("Node.js is listening on port 8080"); 
