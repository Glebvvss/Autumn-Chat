import React, { Component } from 'react';

import MessageList from './components/MessageList/MessageList.jsx';
import NewMessageForm from './components/NewMessageForm.jsx';

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