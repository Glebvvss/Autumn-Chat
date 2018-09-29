let defaultState = {
  recivedRequests: [],
  sendedRequests: [],
  friends: []
};

export function friends(state = defaultState, action) {
  if ( action.type === 'FETCH_FRIENDS' ) {
    return {
      ...state,
      friends: action.payload
    }
  }
  if ( action.type === 'FETCH_RECIVED_FRIENDSHIP_REQUESTS' ) {
    return {
      ...state,
      recivedRequests: action.payload
    }
  }
  if ( action.type === 'FETCH_SENDED_FRIENDSHIP_REQUESTS' ) {
    return {
      ...state,
      sendedRequests: action.payload
    }
  }
  return state;
}