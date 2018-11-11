import { cloneObject }  from '../functions.js';

let defaultState = {
  loadedHistoryPosts: [],
  countLoads: 0,
  countPostsPerPage: 5,
  fullHistoryLoaded: false,
  startPointPostId: null,
};

export function history(state = defaultState, action) {

  if ( action.type === 'ADD_NEW_HISTORY_POST' ) {
    let updatedLoadedHistoryPosts = action.payload.concat(state.loadedHistoryPosts);
    return {
      ...state,
      loadedHistoryPosts: cloneObject(updatedLoadedHistoryPosts),
    };
  }

  if ( action.type === 'SET_FULL_HISTORY_LOADED' ) {
    return {
      ...state,
      fullHistoryLoaded: true,
    };
  }

  if ( action.type === 'RESET_FULL_HISTORY_LOADED' ) {
    return {
      ...state,
      fullHistoryLoaded: false,
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
      countLoads: state.countLoads + 1
    };
  }

  return state;
};