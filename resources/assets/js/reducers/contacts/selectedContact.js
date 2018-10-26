import { cloneObject }  from '../../functions.js';

let defaultState = {
  id: null,
  type: null,
  members: [],
  friendsWhoNotInSelectedContact: [],
  newMembersIdToContact: [],
};

export function selectedContact(state = defaultState, action) {

  if ( action.type === 'RESET_CONTACT_PARAMS' ) {
    return {
      ...defaultState
    }
  }

  if ( action.type === 'FETCH_FRIENDS_WHO_NOT_IN_SELECTED_CONTACT' ) {
    return {
      ...state,
      friendsWhoNotInSelectedContact: action.payload
    }
  }

  if ( action.type === 'FETCH_MEMBERS_OF_SELECTED_CONTACT' ) {
    return {
      ...state,
      members: action.payload
    }
  }

  if ( action.type === 'SET_SELECTED_CONTACT_ID' ) {
    return {
      ...state,
      id: action.payload,
    };
  }

  if ( action.type === 'SET_SELECTED_CONTACT_TYPE' ) {
    return {
      ...state,
      type: action.payload,
    };
  }

  if ( action.type === 'UPDATE_NEW_MEMBERS_ID_TO_CONTACT_LIST' ) {

    let clickedFriendId = action.payload;

    if ( state.newMembersIdToContact.indexOf(clickedFriendId) === -1 ) {
      state.newMembersIdToContact.push(clickedFriendId);
    } else {
      const elementToDelete = state.newMembersIdToContact.indexOf(clickedFriendId);
      state.newMembersIdToContact.splice(elementToDelete, 1);
    }

    return {
      ...state,
      newMembersIdToCantact: cloneObject(state.newMembersIdToCantact)
    };
  }
  
  return state;
}