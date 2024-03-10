const http = require('node:http');
const fs = require('fs');
const index = fs.readFileSync('index.html').toString();

const host = '127.0.0.1';
var port = process.env.PORT;
    port = (typeof port !== 'undefined') ? port : 3000;

const file = index.replace("<hr/>", `<hr/> <h2> Port configuration </h2> <p>Your node application have to listen on port ${port}. Alternatively, you can get port var from envirronment with the following: </p> <pre> process.env.PORT; </pre>`);

const server = http.createServer((req, res) => {
  res.statusCode = 200;
  res.setHeader('Content-Type', 'text/html');
  res.end(file);
});

server.listen(port, host, () => {
   console.log('Web server running at http://%s:%s', host, port);
});
