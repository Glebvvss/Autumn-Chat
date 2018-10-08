let defaultState = {
  selectedGroupId: null,
  friendsWhoNotInSelectedGroup: [],
  membersOfSelectedGroup: []
};

export function selectedGroup(state = defaultState, action) {
  if ( action.type === 'FETCH_FRIENDS_WHO_NOT_IN_SELECTED_GROUP' ) {
    return {
      ...state,
      friendsWhoNotInSelectedGroup: action.payload
    }
  }
  if ( action.type === 'FETCH_MEMBERS_OF_SELECTED_GROUP' ) {
    return {
      ...state,
      membersOfSelectedGroup: action.payload
    }
  }
  if ( action.type === 'SET_SELECTED_GROUP_ID' ) {
    return {
      ...state,
      selectedGroupId: action.payload,
    };
  }
  return state;
}