import { scrfToken, makeUriForRequest } from '../functions.js';

export const sendRequestForFriendship = (friendUsername) => dispatch => {
  if ( friendUsername === '' ) {
    dispatch({type: 'OUTPUT_NOTIFICATION', payload: 'User name can`t be empty!'});
  }

  fetch( makeUriForRequest('/send-friend-for-request/' + friendUsername),  {
    method: 'get'
  }).then(response => {
    response.json().then(data => {
      dispatch({type: 'OUTPUT_NOTIFICATION', payload: data.message});
    });
  });
};

export const getFriendshipRequestSendedToMe = () => dispatch => {

}

export const getSearchMatchesList = (usernameOccurrence) => dispatch => {
  fetch( makeUriForRequest('/search-friend/' + usernameOccurrence), {
    method: 'get'
  }).then((response) => {
    response.json().then((data) => {
      dispatch({type: 'SEARCH_FRIENDS_BY_OCCURRENCE', payload: data.matchUsernames});
    });
  });
};

