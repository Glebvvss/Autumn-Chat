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