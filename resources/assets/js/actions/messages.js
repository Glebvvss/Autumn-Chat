import { getGroups } from './groups';
import { getFriends, 
         getDialogId } from './friends';

import { scrfToken, 
         makeUriForRequest, 
         scrollDocumentToBottom } from '../functions.js';

export const getMoreOldMessages = (contactId, numberScrollLoad, startPointMessageId) => dispatch => {
  fetch( makeUriForRequest('/get-more-old-messages-of-contact/'+contactId+'/'+numberScrollLoad+'/'+startPointMessageId), {
    method: 'get'
  })
  .then(response => {
    response.json().then(data => {
      dispatch({ 
        type:    'FETCH_MORE_OLD_MESSAGES_TO_LIST',
        payload: data.messages 
      });
    });
  });
};

export const getLatestMessages = contactId => dispatch => {
  fetch( makeUriForRequest('/get-latest-messages-of-contact/' + contactId), {
    method: 'get'
  })
  .then(response => {
    response.json().then(data => {
      dispatch({ 
        type:    'FETCH_LATEST_MESSAGES_OF_CONTACT',
        payload: data.messages 
      });
    });
  });
};

export const addNewMessageToList = message => dispatch => {
  dispatch({ type: 'ADD_NEW_MESSAGE_TO_LIST', payload: message });

  setTimeout(() => {
    scrollDocumentToBottom();
  }, 2000);
};

export const getLastMessagesOfDialog = friendId => dispatch => {
  getDialogId(friendId).then(response => {
    response.json().then(data => {
      dispatch( getLatestMessages(data.dialogId) );
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