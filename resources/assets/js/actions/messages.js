import { getFriends, 
         getDialogId } from './friends';

import { getGroups } from './groups';
import { scrfToken, 
         makeUriForRequest, 
         scrollDocumentToBottom } from '../functions.js';

export const getMessages = contactId => dispatch => {
  fetch( makeUriForRequest('/get-messages-of-contact/' + contactId), {
    method: 'get'
  })
  .then(response => {
    response.json().then(data => {
      dispatch({ 
        type:    'FETCH_MESSAGES_OF_SELECTED_CONTACT',
        payload: data.messages 
      });
      scrollDocumentToBottom();
    });
  });
};

export const addNewMessageToList = message => dispatch => {
  dispatch({ type: 'ADD_NEW_MESSAGE_TO_LIST', payload: message });

  setTimeout(() => {
    scrollDocumentToBottom();
  }, 2000);
};

export const getMessagesOfDialog = friendId => dispatch => {
  getDialogId(friendId).then(response => {
    response.json().then(data => {
      dispatch( getMessages(data.dialogId) );
    })
  });
};

export const sendMessage = (contactId, text) => dispatch => {
  fetch( makeUriForRequest('/send-message'), {
    method: 'post',
    headers: {
      'X-CSRF-TOKEN': scrfToken(),
      'Content-Type': 'application/x-www-form-urlencoded'
    },
    body: 
      'contactId=' + contactId + '&' +
      'text='      + text

  })
  .then(response => {
    dispatch( getMessages(contactId) );
  });
}

export const dropUnreadMessageLink = contactId => dispatch => {
  fetch( makeUriForRequest('/drop-unread-message-link/' + contactId), {
    method: 'get'
  })
  .then(response => {
    dispatch( getFriends() );
    dispatch( getGroups() );
  });
};

export const dropUnreadMessageLinkOfDialog = friendId => dispatch => {
  getDialogId(friendId).then(response => {
    response.json().then(data => {
      dispatch( dropUnreadMessageLink(data.dialogId) );
    });
  });
};