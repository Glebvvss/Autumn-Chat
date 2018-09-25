let io    = require('socket.io')(3001),
    Redis = require('ioredis'),
    redis = new Redis();

io.on('connection', function(socket) {
  io.send('testuque');
});

redis.psubscribe('*', (error, count) => {
  console.log(error);
});

redis.on('pmessage', (pattern, chanel, message) => {
  console.log(message);
});