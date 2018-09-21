let defaultState = {
  friendshipRequests: [],
  friends: []
};

export function friends(state = defaultState, action) {
  if ( action.type === 'FETCH_FRIENDS' ) {
    return {
      ...state,
      friends: action.payload
    }
  }
  if ( action.type === 'FETCH_FRIENDSHIP_REQUESTS' ) {
    return {
      ...state,
      friendshipRequests: action.payload
    }
  }
  return state;
}