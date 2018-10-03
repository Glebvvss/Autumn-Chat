let defaultState = {
  groupManagerVisible: false,
  friendshipRequestsVisible: false,
};

export function sidebarDropdownElements( state = defaultState, action ) {

  if ( action.type === 'CHANGE_VISIBLE_STATUS_GROUP_MANAGER' ) {
    if ( state.groupManagerVisible === false ) {
      return {
        ...defaultState,
        groupManagerVisible: true,
      }
    } else {
      return {
        ...state,
        groupManagerVisible: false,
      }
    }
  }

  if ( action.type === 'CHANGE_VISIBLE_STATUS_FRIENSHIP_REQUESTS' ) {
    if ( state.friendshipRequestsVisible === false ) {
      return {
        ...defaultState,
        friendshipRequestsVisible: true,
      }
    } else {
      return {
        ...state,
        friendshipRequestsVisible: false,
      }
    }
  }

  return state;
}