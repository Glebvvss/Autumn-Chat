let defaultState = {
  countNewRecived: 0,
  recived: [],
  sended: [],
};

export function friendshipRequests(state = defaultState, action) {

  if ( action.type === 'FETCH_RECIVED_FRIENDSHIP_REQUESTS' ) {
    return {
      ...state,
      recived: action.payload
    }
  }

  if ( action.type === 'FETCH_SENDED_FRIENDSHIP_REQUESTS' ) {
    return {
      ...state,
      sended: action.payload
    }
  }

  if ( action.type === 'FETCH_COUNT_NEW_RECIVED_FRIENSHIP_REQUESTS' ) {
    return {
      ...state,
      countNewRecived: action.payload
    }
  }
  
  return state;
}