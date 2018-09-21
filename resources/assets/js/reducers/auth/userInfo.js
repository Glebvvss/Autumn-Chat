const defaultState = {
  username: '',
  id: ''
}

export const userInfo = (state = defaultState, action) => {  
  if ( action.type === 'FETCH_USERNAME' ) {
    return {
      ...state,
      username: action.payload.username
    };
  }
  if ( action.type === 'FETCH_USER_ID' ) {
    return {
      ...state,
      id: action.payload.userID
    }; 
  }
  return state;
}