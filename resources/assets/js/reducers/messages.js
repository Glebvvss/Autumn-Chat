let defaultState = {
  messagesOfSelectedContact: []
};

export function messages(state = defaultState, action) {
  if ( action.type === 'FETCH_MESSAGES_OF_SELECTED_CONTACT' ) {
    return {
      ...state,
      messagesOfSelectedContact: action.payload    
    };
  }
  return state;
};