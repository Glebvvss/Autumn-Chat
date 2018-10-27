import React, { Component } from 'react';

class Message extends Component {

  constructor(props) {
    super(props);
  }

  render() {
    return (
      <div className="message-out-block" data-messageID={this.props.messageDetails.id}>
        <div className="message">
          <div className="username-of-writer-message">
            {this.props.messageDetails.user.username}
          </div>
          <hr />
          <span>{this.props.messageDetails.text}</span>
        </div>
      </div>
    );
  }

}

export default Message;