import { cloneObject }  from '../functions.js';

let defaultState = {
  loadedHistoryPosts: [],
  countLoadedPages: 0,
  countPostsPerPage: 5,
  fullHistoryLoaded: false,
  startPointPostId: null,
};

export function history(state = defaultState, action) {

  if ( action.type === 'SET_FULL_HISTORY_LOADED' ) {
    return {
      ...state,
      fullHistoryLoaded: true,
    };
  }

  if ( action.type === 'RESET_FULL_HISTORY_LOADED' ) {
    return {
      ...state,
      fullHistoryLoadedallHistoryLoaded: false,
    };
  }

  if ( action.type === 'SET_START_POINT_HISTORY_POST_ID' ) {
    return {
      ...state,
      startPointPostId: action.payload
    };
  }

  if ( action.type === 'UPDATE_LOADED_HISTORY_LIST' ) {
    let updatedLoadedHistoryPosts = state.loadedHistoryPosts.concat(action.payload);
    return {
      ...state,
      loadedHistoryPosts: cloneObject(updatedLoadedHistoryPosts),
      countLoadedPages: state.countLoadedPages + 1
    };
  }

  return state;
};