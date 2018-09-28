import { scrfToken, makeUriForRequest } from '../functions.js';

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

export const comfirmFriendRequest = (senderUsername) => dispatch => {
  fetch( makeUriForRequest('/confirm-recivied-friendship-request/' + senderUsername), {
    method: 'get'
  }).then(response => {
    response.json().then(data => {
      dispatch({type: 'OUTPUT_NOTIFICATION', payload: data.message});
      dispatch(getRecivedFriendshipRequests());
      dispatch(getFriends());
    })
  });
};

export const cancelReciviedFriendRequest = (senderUsername) => dispatch => {
  fetch( makeUriForRequest('/cancel-recivied-friendship-request/' + senderUsername), {
    method: 'get'
  }).then(response => {
    response.json().then(data => {
      dispatch({type: 'OUTPUT_NOTIFICATION', payload: data.message});
      dispatch(getRecivedFriendshipRequests());
    })
  });
};

export const cancelSendedFriendshipRequest = (recipientUsername) => dispatch => {
  fetch( makeUriForRequest('/cancel-recivied-friendship-request/' + recipientUsername), {
    method: 'get'
  }).then(response => {
    response.json().then(data => {
      dispatch({type: 'OUTPUT_NOTIFICATION', payload: data.message});
      dispatch(getRecivedFriendshipRequests());
    })
  });
};

export const getRecivedFriendshipRequests = () => dispatch => {
  fetch( makeUriForRequest('/get-recived-friendship-requests'), {
    method: 'get'
  }).then(response => {
    response.json().then(data => {      
      dispatch({ 
        type: 'FETCH_RECIVED_FRIENDSHIP_REQUESTS', payload: data.friendshipRequests });
    });
  });
};

export const getSendedFriendshipRequests = () => dispatch => {
  fetch( makeUriForRequest('/get-sended-friendship-requests'), {
    method: 'get'
  }).then(response => {
    response.json().then(data => {      
      dispatch({ 
        type: 'FETCH_SENDED_FRIENDSHIP_REQUESTS', payload: data.friendshipRequests });
    });
  });
};

export const getSearchMatchesList = (usernameOccurrence) => dispatch => {  
  fetch( makeUriForRequest('/search-friend/' + usernameOccurrence), {
    method: 'get'
  }).then(response => {
    response.json().then(data => {
      dispatch({
        type: 'SEARCH_FRIENDS_BY_OCCURRENCE', payload: data.matchUsernames});
    });
  });
};