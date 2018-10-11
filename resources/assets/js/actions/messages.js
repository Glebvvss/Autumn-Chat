import { scrfToken, 
         makeUriForRequest, 
         scrollDocumentToBottom } from '../functions.js';


export const getMessagesOfGroup = groupId => dispatch => {
  fetch( makeUriForRequest('/get-message-of-group/' + groupId), {
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

export const getMessagesOfDialod = () => dispatch => {

};

export const sendMessage = (groupId, text) => dispatch => {
  fetch( makeUriForRequest('/send-message'), {
    method: 'post',
    headers: {
      'X-CSRF-TOKEN': scrfToken(),
      'Content-Type': 'application/x-www-form-urlencoded'
    },
    body: 
      'groupId=' + groupId + '&' +
      'text='    + text

  })
  .then(response => {
    dispatch( getMessagesOfGroup(groupId) );
  });
}