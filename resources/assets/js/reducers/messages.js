import { cloneObject }  from '../functions.js';

let defaultState = {
  startPointMessageId: null,
  messagesOfSelectedContact: [],
  loadingOldMessagesHaveResult: null,
};

export function messages(state = defaultState, action) {

  if ( action.type === 'FETCH_MORE_OLD_MESSAGES_TO_LIST' ) {

    if ( action.payload === 'NO RESULTS' ) {
      return {
        ...state,
        loadingOldMessagesHaveResult: false
      };      
    }

    let updatedMessageList = action.payload.concat(state.messagesOfSelectedContact);
    return {
      ...state,
      messagesOfSelectedContact: cloneObject( updatedMessageList ),
      loadingOldMessagesHaveResult: true
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

  if ( action.type === 'FETCH_LATEST_MESSAGES_OF_CONTACT' ) {
    return {
      ...state,
      messagesOfSelectedContact: action.payload,
      startPointMessageId: action.payload[0].id
    };
  }
  
  return state;
};