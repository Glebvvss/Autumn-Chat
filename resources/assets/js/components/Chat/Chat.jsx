import React, { Component } from 'react';
import MemberList from './components/MemberList.jsx';
import MessageList from './components/MessageList/MessageList.jsx';
import NewMessageForm from './components/NewMessageForm.jsx';

class Chat extends Component {

  constructor(props) {
    super(props);
  }

  render() {
    return (
      <div className="chat">
        <MemberList />
        <MessageList />
        <NewMessageForm />
      </div>
    );
  }

}

export default Chat;