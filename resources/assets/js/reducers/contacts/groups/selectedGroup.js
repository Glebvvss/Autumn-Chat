import { cloneObject }  from '../../../functions.js';

let defaultState = {
  selectedGroupId: null,
  membersOfSelectedGroup: [],
  newMembersIdToGroupList: [],
  friendsWhoNotInSelectedGroup: [],
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
  if ( action.type === 'UPDATE_NEW_MEMBERS_ID_TO_GROUP_LIST' ) {

    let clickedFriendId = action.payload;

    if ( state.newMembersIdToGroupList.indexOf(clickedFriendId) === -1 ) {
      state.newMembersIdToGroupList.push(clickedFriendId);
    } else {
      const elementToDelete = state.newMembersIdToGroupList.indexOf(clickedFriendId);
      state.newMembersIdToGroupList.splice(elementToDelete, 1);
    }

    return {
      ...state,
      newMembersIdToGroupList: cloneObject(state.newMembersIdToGroupList)
    };
  }
  return state;
}