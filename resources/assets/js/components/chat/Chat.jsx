import React, { Component } from 'react';
import MessageList from './components/MessageList';

class Chat extends Component {

  constructor(props) {
    super(props);
  }

  render() {
    return (
      <div className="chat">
        <MessageList />

        <form className="message-form">
          <div className="message-block">
            <textarea></textarea>
          </div>
        </form>

      </div>
    );
  }

}

export default Chat;