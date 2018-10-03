import { scrfToken, makeUriForRequest } from '../functions.js';
import { getFriends } from './friends.js';

export const send = (recipientUsername) => dispatch => {
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

export const comfirm = (senderId) => dispatch => {
  fetch( makeUriForRequest('/confirm-friendship-request/' + senderId), {
    method: 'get'
  }).then(response => {
    response.json().then(data => {
      dispatch({type: 'OUTPUT_NOTIFICATION', payload: data.message});
      dispatch(getRecivedFriendshipRequests());
      dispatch(getFriends());
    })
  });
};

export const cancelRecived = (senderId) => dispatch => {
  fetch( makeUriForRequest('/cancel-recived-friendship-request/' + senderId), {
    method: 'get'
  }).then(response => {
    response.json().then(data => {
      dispatch({type: 'OUTPUT_NOTIFICATION', payload: data.message});
      dispatch(getRecivedFriendshipRequests());
    })
  });
};

export const cancelSended = (recipientId) => dispatch => {
  fetch( makeUriForRequest('/cancel-sended-friendship-request/' + recipientId), {
    method: 'get'
  }).then(response => {
    response.json().then(data => {
      dispatch({type: 'OUTPUT_NOTIFICATION', payload: data.message});
      dispatch(getSendedFriendshipRequests());
    })
  });
};

export const getRecivedAll = () => dispatch => {
  fetch( makeUriForRequest('/get-recived-friendship-requests'), {
    method: 'get'
  }).then(response => {
    response.json().then(data => {      
      dispatch({ 
        type: 'FETCH_RECIVED_FRIENDSHIP_REQUESTS', payload: data.friendshipRequests });
    });
  });
};

export const getSendedAll = () => dispatch => {
  fetch( makeUriForRequest('/get-sended-friendship-requests'), {
    method: 'get'
  }).then(response => {
    response.json().then(data => {      
      dispatch({ 
        type: 'FETCH_SENDED_FRIENDSHIP_REQUESTS', payload: data.friendshipRequests });
    });
  });
};

export const readNewRecivedAll = () => dispatch => {
  fetch( makeUriForRequest('/read-new-recived-friendship-requests'), {
    method: 'get'
  }).then(response => {
    dispatch({ 
      type: 'FETCH_COUNT_NEW_RECIVED_FRIENSHIP_REQUESTS', payload: 0
    });
  });
};

export const getCountNewRecivedAll = () => dispatch => {
  fetch( makeUriForRequest('/get-count-new-recived-friendship-requests'), {
    method: 'get'
  }).then(response => {
    response.json().then(data => {      
      dispatch({ 
        type: 'FETCH_COUNT_NEW_RECIVED_FRIENSHIP_REQUESTS', payload: data.count 
      });
    });
  });
};