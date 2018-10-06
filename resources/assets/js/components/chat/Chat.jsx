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
            <button>Add Message</button>
          </div>
        </form>

      </div>
    );
  }

}

export default Chat;