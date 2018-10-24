import React, { Component } from 'react';
import { connect } from 'react-redux';

import { getMessages } from '../../../../actions/messages.js';
import Message from './components/Message.jsx';

class MessageList extends Component {

  constructor(props) {
    super(props);
  }

  subscribeOnChangesInMessageList() {
    let socket = io(':3001'),
        room   = 'messages-of-contact:' + this.props.selectedContactId;

    socket.on(room, (socketData) => {
      this.props.getMessages(this.props.selectedContactId);
    });
  }

  render() {
    this.subscribeOnChangesInMessageList();
    return (
      <div className="message-list">
        {
          this.props.messages.map((item, index) => (
            <Message key={index} messageDetails={item} /> 
          ))
        }
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
    getMessages: selectedContactId => {
      dispatch( getMessages(selectedContactId) );
    }
  })
)(MessageList);