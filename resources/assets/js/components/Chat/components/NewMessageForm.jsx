import React, { Component } from 'react';
import { connect } from 'react-redux';

import { sendMessage,
         dropUnreadMessageLink } from '../../../actions/messages';

class NewMessageForm extends Component {

  constructor(props) {
    super(props);

    this.state = {
      messageTextarea: ''
    }
  }

  addMessageByEnterClick(event) {
    const text = event.target.value.trim();
    this.blockDefaultEnterEventInTextarea(event);

    if ( event.key === 'Enter' && text !== '' ) {
      this.props.sendMessage(this.props.selectedContactId, text);
      this.clearTextarea();
    }
  }

  blockDefaultEnterEventInTextarea(event) {
    if ( event.key === 'Enter' ) {
      event.preventDefault();
    }
  }

  clearTextarea() {
    this.setState({
      ...this.state,
      messageTextarea: ''
    });
  }

  hangleTextarea(event) {
    this.setState({
      ...this.state,
      messageTextarea: event.target.value
    });
  }

  initialDropUnreadMessageLink() {
    this.props.dropUnreadMessageLink(this.props.selectedContactId);
  }

  render() {
    return (
      <form className="message-form">
        <div className="message-block">
          <textarea wrap="off"
                    value={this.state.messageTextarea} 
                    onChange={this.hangleTextarea.bind(this)}
                    onKeyDown={this.addMessageByEnterClick.bind(this)}
                    onClick={this.initialDropUnreadMessageLink.bind(this)}>
            
          </textarea>
        </div>
      </form>
    );
  }

}

export default connect(
  state => ({
    selectedContactId: state.selectedContact.id
  }),
  dispatch => ({
    sendMessage: (contactId, text) => {
      dispatch( sendMessage(contactId, text) );
    },
    dropUnreadMessageLink: contactId => {
      dispatch( dropUnreadMessageLink(contactId) );
    }
  }),
)(NewMessageForm);