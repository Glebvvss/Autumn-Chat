let defaultState = {
  contactType: '',
  messagesOfSelectedContact: []
};

export function messages(state = defaultState, action) {

  if ( action.type === 'FETCH_MESSAGES_OF_SELECTED_CONTACT' ) {
    return {
      ...state,
      messagesOfSelectedContact: action.payload    
    };
  }

  if ( action.type === 'SET_CONTACT_TYPE' ) {
    return {
      ...state,
      contactType: action.payload
    }
  }
  
  return state;
};