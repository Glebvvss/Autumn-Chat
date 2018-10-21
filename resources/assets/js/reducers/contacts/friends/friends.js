let defaultState = {
  friends: []
};

export function friends(state = defaultState, action) {

  if ( action.type === 'FETCH_FRIENDS' ) {
    return {
      ...state,
      friends: action.payload
    }
  }
  
  return state;
}