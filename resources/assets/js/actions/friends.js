import { scrfToken, makeUriForRequest } from '../functions.js';

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

