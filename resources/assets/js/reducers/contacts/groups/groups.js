let defaultState = {
  groups: [],
};

export function groupList( state = defaultState, action ) {
  if ( action.type === 'FETCH_GROUPS' ) {
    return {
      ...state,
      groups: action.payload
    }
  }
  if ( action.type === 'CREATE_GROUP' ) {

  }
  if ( action.type === 'ADD_TO_GROUP' ) {

  }
  if ( action.type === 'LEAVE_GROUP' ) {

  }
  return state;
}