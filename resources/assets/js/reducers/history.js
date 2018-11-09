import { cloneObject }  from '../functions.js';

let defaultState = {
  loadedHistoryPosts: [],
  countLoadedPages: 0,
  countPostsPerPage: 5,
  allHistoryLoaded: false,
  startPointPostId: null,
};

export function history(state = defaultState, action) {

  if ( action.type === 'SET_START_POINT_HISTORY_POST_ID' ) {
    return {
      ...state,
      startPointPostId: action.payload
    };
  }

  if ( action.type === 'ADD_HISTORY_PAGE_CONTENT' ) {

    let updatedLoadedHistoryPosts = state.loadedHistoryPosts.concat(action.payload);

    return {
      ...state,
      loadedHistoryPosts: cloneObject(updatedLoadedHistoryPosts),
      countLoadedPages: state.countLoadedPages + 1
    };
  }

  return state;
};