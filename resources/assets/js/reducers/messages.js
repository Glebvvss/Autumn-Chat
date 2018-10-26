import { cloneObject }  from '../functions.js';

let defaultState = {
  contactType: '',
  messagesOfSelectedContact: []
};

export function messages(state = defaultState, action) {

  if ( action.type === 'ADD_NEW_MESSAGE_TO_LIST' ) {
    return {
      ...state,
      messagesOfSelectedContact: [
        ...state.messagesOfSelectedContact,
        action.payload
      ]
    };
  }

  if ( action.type === 'RESET_MESSAGE_LIST' ) {
    return {
      ...defaultState
    };
  }

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