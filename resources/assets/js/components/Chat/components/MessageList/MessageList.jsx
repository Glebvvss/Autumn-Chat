import React, { Component } from 'react';
import { connect } from 'react-redux';
import { getFriends } from '../../../../actions/friends.js';
import { getGroups } from '../../../../actions/groups.js';
import Message from './components/Message.jsx';

import { getLastMessages,
         addNewMessageToList } from '../../../../actions/messages.js';

import { socket, scrollDocumentToBottom } from '../../../../functions.js';



class MessageList extends Component {

  constructor(props) {
    super(props);
  }

  componentDidUpdate(prevProps) {
    this.scrollToBottom();

    if ( this.props !== prevProps ) {
      this.subscribeOnNewMessagesOfContact().bind(this);
    }
  }

  scrollToBottom() {
    let element = document.getElementById('end-of-messages');
    element.scrollIntoView();
  }

  subscribeOnNewMessagesOfContact() {
    let room   = 'add-new-message-to-list:' + this.props.selectedContactId;

    socket.once(room, (message) => {
      this.props.addNewMessageToList(message);
    });
  }

  render() {
    return (
      <div className="message-list">
        {
          this.props.messages.map((item, index) => (
            <Message key={index} messageDetails={item} /> 
          ))
        }

        <div id="end-of-messages"></div>

      </div>
    );
  }

}

export default connect(
  state => ({
    messages:          state.messages.messagesOfSelectedContact,
    selectedContactId: state.selectedContact.id
  }), 
  dispatch => ({
    getLastMessages: selectedContactId => {
      dispatch( getLastMessages(selectedContactId) );
    },
    updateFriendList: () => {
      dispatch( getFriends() );
    },
    updateGroupList: () => {
      dispatch( getGroups() );
    },
    addNewMessageToList: message => {
      dispatch( addNewMessageToList(message) );
    }
  })
)(MessageList);