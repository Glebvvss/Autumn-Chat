import React, { Component } from 'react';
import MessageList from './components/MessageList/MessageList';
import NewMessageForm from './components/NewMessageForm';

class Chat extends Component {

  constructor(props) {
    super(props);
  }

  render() {
    return (
      <div className="chat">
        <MessageList />
        <NewMessageForm />
      </div>
    );
  }

}

export default Chat;