import { cloneObject }  from '../functions.js';

let defaultState = {
  startPointMessageId: null,
  messagesOfSelectedContact: [],
  allOldMessagesLoaded: false,
};

export function messages(state = defaultState, action) {

  if ( action.type === 'FETCH_MORE_OLD_MESSAGES_TO_LIST' ) {
    let updatedMessageList = action.payload.messages.concat(state.messagesOfSelectedContact);
    return {
      ...state,
      messagesOfSelectedContact: cloneObject( updatedMessageList ),
      allOldMessagesLoaded: action.payload.allOldMessagesLoaded
    };
  }

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

  if ( action.type === 'RESET_ALL_OLD_MESSAGES_LOADED' ) {
    return {
      ...state,
      allOldMessagesLoaded: false
    };
  }

  if ( action.type === 'FETCH_LATEST_MESSAGES_OF_CONTACT' ) {
    return {
      ...state,
      messagesOfSelectedContact: action.payload,
      startPointMessageId: action.payload[0].id
    };
  }
  
  return state;
};