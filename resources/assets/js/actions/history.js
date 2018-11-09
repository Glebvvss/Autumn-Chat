import { scrfToken, makeUriForRequest } from '../functions.js';

export const addHistoryPageContect = (pageNumber, startPointPostId) => dispatch => {
  fetch( makeUriForRequest('/get-history-page/' + pageNumber + '/' + startPointPostId), {
    method: 'get'
  })
  .then(response => {
    response.json().then(data => {
      dispatch({ type: 'ADD_HISTORY_PAGE_CONTENT', payload: data.historyPage });
    });
  });
};

export const updateHistoryList = countLoadedHistoryPages => dispatch => {
  fetch( makeUriForRequest('/get-history-page/' + pageNumber), {
    method: 'get'
  })
  .then(response => {
    response.json().then(data => {
      dispatch({ type: 'FETCH_HISTORY_PAGE', payload: data.historyPage });
    });
  }); 
};

export const resetNewMerkersOfHistypePosts = countLoadedHistoryPages => dispatch => {
  fetch( makeUriForRequest('/reset-new-markers-of-history-posts'), {
    method: 'get'
  })
  .then(response => {
    response.json().then(data => {
      dispatch( updateHistoryList(countLoadedHistoryPages) );
    });
  });
};

export const getFirstPageByStartPointId = () => dispatch => {
  fetch( makeUriForRequest('/get-start-point-history-post-id'), {
    method: 'get'
  })
  .then(response => {
    response.json().then(data => {
      dispatch({ type: 'SET_START_POINT_HISTORY_POST_ID', payload: data.startPointPostId });
      dispatch( addHistoryPageContect(1, data.startPointPostId) );
    });
  });
};