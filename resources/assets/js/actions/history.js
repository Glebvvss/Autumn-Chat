import { scrfToken, makeUriForRequest } from '../functions.js';

const loadLatestHistoryList = startPointPostId => dispatch => {
  fetch( makeUriForRequest('/get-latest-history-load-list/' + startPointPostId), {
    method: 'get'
  })
  .then(response => {
    response.json().then(data => {
      console.log(data);
      dispatch({ type: 'UPDATE_LOADED_HISTORY_LIST', payload: data.historyPosts });
    });
  });
};

export const getHistoryMoreOldLoadList = (loadNumber, startPointPostId) => dispatch => {
  fetch( makeUriForRequest('/get-history-more-old-load-list/' + loadNumber + '/' + startPointPostId), {
    method: 'get'
  })
  .then(response => {
    response.json().then(data => {
      dispatch({ type: 'UPDATE_LOADED_HISTORY_LIST', payload: data.historyPosts });

      if ( data.historyPosts.length < 5 ) {
        dispatch({ type: 'SET_FULL_HISTORY_LOADED' });
      }
      
    });
  });
};

export const getLatestHistoryList = () => dispatch => {
  fetch( makeUriForRequest('/get-start-point-history-post-id'), {
    method: 'get'
  })
  .then(response => {
    response.json().then(data => {
      dispatch({ type: 'SET_START_POINT_HISTORY_POST_ID', payload: data.startPointPostId });
      dispatch( loadLatestHistoryList(data.startPointPostId) );
    });
  });
};