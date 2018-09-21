import { scrfToken, makeUriForRequest } from '../functions.js';

export const sendRequestForFriendship = (friendUsername) => dispatch => {
  fetch( makeUriForRequest('/send-friend-for-request/' + friendUsername),  {
    method: 'get'
  }).then(response => {
    response.json().then(data => {
      dispatch({type: 'OUTPUT_NOTIFICATION', payload: data.message});
    });
  });
};

export const getSearchMatchesList = (usernameOccurrence) => dispatch => {
  fetch( makeUriForRequest('/search-friend/' + usernameOccurrence), {
    method: 'get'
  }).then((response) => {
    response.json().then((data) => {
      dispatch({type: 'SEARCH_FRIENDS_BY_OCCURRENCE', payload: data.matchUsernames});
    });
  });
};

