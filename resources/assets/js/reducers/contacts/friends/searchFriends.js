export function searchFriends(state = [], action) {
  if ( action.type === 'SEARCH_FRIENDS_BY_OCCURRENCE' ) {
    return action.payload;
  }
  if ( action.type === 'CLEAR_SEARCH_MATCH_LIST' ) {
    return [];
  }
  return state;
}