let io    = require('socket.io')(3001),
    Redis = require('ioredis'),
    redis = new Redis();

io.on('connection', (socket) => {

  redis.psubscribe('*', (error, count) => {
    
  });

  redis.on('pmessage', (pattern, chanel, message) => {
    let messageJSON = JSON.parse(message);

    if ( messageJSON.event === 'UPDATE_MESSAGE_LIST' ) {
      updateMessageList(socket, messageJSON);
    }

    if ( messageJSON.event === 'UPDATE_FRIENDSHIP_REQUEST_LIST' ) {
      updateFriendshipRequestList(socket, messageJSON);      
    }

    if ( messageJSON.event === 'UPDATE_FRIEND_LIST' ) {
      updateFriendList(socket, messageJSON);
    }
  });
});

function updateMessageList(socket, messageJSON) {
  let groupId = messageJSON.data.idGroup,
      room    = 'messages-of-contact:' + groupId;

  console.log(messageJSON);

  socket.emit(room, 'update');
}

function updateFriendshipRequestList(socket, messageJSON) {

  if ( messageJSON.data.type === 'sended' ) {
    let userId = messageJSON.data.idUser;
        room   = 'sended-friend-requests-of:' + userId;

    socket.emit(room, 'update');

  } else if ( messageJSON.data.type === 'recived' ) {
    let userId = messageJSON.data.idUser;
        room   = 'recivied-friend-requests-of:' + userId;

    socket.emit(room, 'update');
  }
}

function updateFriendList(socket, messageJSON) {
  let userId = messageJSON.data.idUser,
      room   = 'friends-by-user-id:' + userId;

  socket.emit(room, 'update');
}