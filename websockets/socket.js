let io    = require('socket.io')(3001),
    Redis = require('ioredis'),
    redis = new Redis();

io.on('connection', (socket) => {
  redis.psubscribe('*', (error, count) => {
    
    redis.on('pmessage', (pattern, chanel, message) => {
      let messageJSON = JSON.parse(message);

      if ( messageJSON.event === 'NEW_PUBLIC_GROUP_CREATED' ) {
        newPublicGroupCreated(socket, messageJSON);
      }

      if ( messageJSON.event === 'UPDATE_UNREAD_MESSAGE_MARKERS' ) {
        updateUnreadMessageMarkers(socket, messageJSON);
      }

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
});

function newPublicGroupCreated(socket, messageJSON) {
  let memberIdList = messageJSON.data.memberIdList;

  memberIdList.map(memberId => {
    let room    = 'new-public-group-created:' + memberId;
    socket.emit(room, 'update');
  });
}

function updateUnreadMessageMarkers(socket, messageJSON) {
  let userIdList = messageJSON.data.userIdList;

  userIdList.map(userId => {
    let room    = 'update-unread-message-merkers-of-user-id:' + userId;
    socket.emit(room, 'update');
  });
}

function updateMessageList(socket, messageJSON) {
  let groupId = messageJSON.data.groupId,
      room    = 'messages-of-contact:' + groupId;

  socket.emit(room, 'update');
}

function updateFriendshipRequestList(socket, messageJSON) {

  if ( messageJSON.data.type === 'sended' ) {
    let userId = messageJSON.data.userId;
        room   = 'sended-friend-requests-of:' + userId;

    socket.emit(room, 'update');

  } else if ( messageJSON.data.type === 'recived' ) {
    let userId = messageJSON.data.userId;
        room   = 'recivied-friend-requests-of:' + userId;

    socket.emit(room, 'update');
  }
}

function updateFriendList(socket, messageJSON) {
  let userId = messageJSON.data.userId,
      room   = 'friends-by-user-id:' + userId;

  socket.emit(room, 'update');
}