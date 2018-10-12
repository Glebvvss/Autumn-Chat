import React, { Component } from 'react';
import { connect } from 'react-redux';
import { sendMessageToGroup } from '../../../actions/messages';

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
      this.props.sendMessageToGroup(this.props.selectedGroupId, text);
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

  render() {
    return (
      <form className="message-form">
        <div className="message-block">
          <textarea wrap="off"
                    value={this.state.messageTextarea} 
                    onChange={this.hangleTextarea.bind(this)}
                    onKeyDown={this.addMessageByEnterClick.bind(this)}>
            
          </textarea>
        </div>
      </form>
    );
  }

}

export default connect(
  state => ({
    selectedGroupId: state.selectedGroup.selectedGroupId
  }),
  dispatch => ({
    sendMessageToGroup: (groupId, text) => {
      dispatch( sendMessageToGroup(groupId, text) );
    }
  }),
)(NewMessageForm);
