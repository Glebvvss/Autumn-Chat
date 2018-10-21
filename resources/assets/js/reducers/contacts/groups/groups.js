let defaultState = {
  groups: []
};

export function groups( state = defaultState, action ) {

  if ( action.type === 'FETCH_GROUPS' ) {
    return {
      ...state,
      groups: action.payload
    }
  }
  
  return state;
}