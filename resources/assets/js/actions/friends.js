import { scrfToken, makeUriForRequest } from '../functions.js';

export const updateSenderFriendsAfterConfirmRequest = () => dispatch => {
  fetch( makeUriForRequest('/get-user-id'), {
    method: 'get'
  }).then(response => {
    response.json().then(data => {
      let socket = io(':3001');
      socket.on('add_friend_to_user_' + data.userId, (newFriend) => {
        
      });
    });
  });
};

export const getFriends = () => dispatch => {
  fetch( makeUriForRequest('/get-friends'), {
    method: 'get'
  }).then(response => {
    response.json().then(data => {
      dispatch({ type: 'FETCH_FRIENDS', payload: data.friends });
    });
  });
};

export const sendRequestForFriendship = (recipientUsername) => dispatch => {
  if ( recipientUsername === '' ) {
    dispatch({type: 'OUTPUT_NOTIFICATION', payload: 'User name can`t be empty!'});
  }

  fetch( makeUriForRequest('/send-friendship-request/' + recipientUsername),  {
    method: 'get'
  }).then(response => {
    response.json().then(data => {
      dispatch({type: 'OUTPUT_NOTIFICATION', payload: data.message});
    });
  });
};

export const comfirmFriendshipRequest = (senderUsername) => dispatch => {
  fetch( makeUriForRequest('/confirm-friendship-request/' + senderUsername), {
    method: 'get'
  }).then(response => {
    response.json().then(data => {
      dispatch({type: 'OUTPUT_NOTIFICATION', payload: data.message});
      dispatch(getFriendshipRequests());
      dispatch(getFriends());
    })
  });
};

export const cancelFriendshipRequest = (senderUsername) => dispatch => {
  fetch( makeUriForRequest('/cancel-friendship-request/' + senderUsername), {
    method: 'get'
  }).then(response => {
    response.json().then(data => {
      dispatch({type: 'OUTPUT_NOTIFICATION', payload: data.message});
      dispatch(getFriendshipRequests());
    })
  });
};

export const getFriendshipRequests = () => dispatch => {
  fetch( makeUriForRequest('/get-friendship-requests'), {
    method: 'get'
  }).then(response => {
    response.json().then(data => {      
      dispatch({ type: 'FETCH_FRIENDSHIP_REQUESTS', payload: data.friendshipRequests });
    });
  });
};

export const getSearchMatchesList = (usernameOccurrence) => dispatch => {  
  fetch( makeUriForRequest('/search-friend/' + usernameOccurrence), {
    method: 'get'
  }).then(response => {
    response.json().then(data => {
      dispatch({type: 'SEARCH_FRIENDS_BY_OCCURRENCE', payload: data.matchUsernames});
    });
  });
};