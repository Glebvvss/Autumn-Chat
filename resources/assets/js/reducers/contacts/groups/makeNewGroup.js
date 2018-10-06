let defaultState = {
  groupMembersIdList: [],
};

export function makeNewGroup( state = defaultState, action ) {
  if ( action.type === 'CHANGE_GROUP_MEMBER_LIST_BEFORE_CREATED' ) {

    let clickedFriendId = action.payload;

    if ( state.groupMembersIdList.indexOf(clickedFriendId) === -1 ) {
      state.groupMembersIdList.push(clickedFriendId);
    } else {
      const elementToDelete = state.groupMembersIdList.indexOf(clickedFriendId);
      state.groupMembersIdList.splice(elementToDelete, 1);
    }

    return {
      ...state,
      groupMembersIdList: clone(state.groupMembersIdList)
    };
  }
  if ( action.type === 'CLEAR_GROUP_MEMBERS_ID_LIST_AFTER_CREATED' ) {
    return {
      ...state,
      groupMembersIdList: []
    };
  }
  return state;
}

function clone(object) {
  return JSON.parse( JSON.stringify(object) );
}