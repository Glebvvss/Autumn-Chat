import React, { Component } from 'react';
import { connect } from 'react-redux';
import Message from './components/Message.jsx';

class MessageList extends Component {

  constructor(props) {
    super(props);
  }

  render() {
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
    messages: state.messages.messagesOfSelectedContact
  })
)(MessageList);