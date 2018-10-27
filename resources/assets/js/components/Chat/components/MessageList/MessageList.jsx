import React, { Component } from 'react';
import { connect } from 'react-redux';
import { getFriends } from '../../../../actions/friends.js';
import { getGroups } from '../../../../actions/groups.js';
import Message from './components/Message.jsx';
import { addNewMessageToList, 
         getMoreOldMessages } from '../../../../actions/messages.js';

import { socket, 
         cloneObject,
         scrollDocumentToBottom } from '../../../../functions.js';

class MessageList extends Component {

  constructor(props) {
    super(props);
    this.getMoreOldMessagesByScrollToTop();

    this.state = {
      numberScrollLoad: 0,
      scrollUp: false
    }
  }

  subscribeOnNewMessagesOfContact() {
    let room   = 'add-new-message-to-list:' + this.props.selectedContactId;

    socket.once(room, (message) => {
      this.notifyComponentAboutScrollDown();

      this.props.addNewMessageToList(message);
    });
  }

  componentDidUpdate(prevProps) {
    if ( this.props.allOldMessagesLoaded !== true ) {
      this.focusOnFirstMessageBeforeLoad();
    }

    if ( this.state.scrollUp === false ) {
      this.scrollToBottom();
    }

    if ( this.props.selectedContactId !== prevProps.selectedContactId ) {
      this.props.resetAllMessagesLoaded();
      this.resetNumberScrollLoad();
    }

    if ( this.props !== prevProps ) {
      this.subscribeOnNewMessagesOfContact().bind(this);
    }
  }

  resetNumberScrollLoad() {
    this.setState({
      ...this.state,
      numberScrollLoad: 0
    });
  }

  getMoreOldMessagesByScrollToTop() {
    document.addEventListener('scroll', () => {
      if ( this.props.allOldMessagesLoaded === true ) {
        return;
      }

      if ( document.documentElement.scrollTop === 0 ) {
        this.state.numberScrollLoad = this.state.numberScrollLoad + 1;

        this.notifyComponentAboutScrollUp();

        this.props.getMoreOldMessages(
          this.props.selectedContactId, 
          this.state.numberScrollLoad, 
          this.props.startPointMessageId
        );    
      }
    });
  }

  focusOnFirstMessageBeforeLoad() {
    const selector = 'div.message-out-block';
    const element = document.querySelectorAll(selector);
    element[9].scrollIntoView();
  }

  notifyComponentAboutScrollUp() {
    this.setState({
      ...this.state,
      scrollUp: true
    });
  }

  notifyComponentAboutScrollDown() {
    this.setState({
      ...this.state,
      scrollUp: false
    });    
  }

  scrollToBottom() {
    let element = document.getElementById('end-of-messages');
    element.scrollIntoView();
  }

  render() {
    return (
      <div className="message-list">
        {
          this.props.messages.map((item, index) => (
            <Message key={index} messageDetails={item} /> 
          ))
        }
        <div id="end-of-messages"></div>
      </div>
    );
  }

}

export default connect(
  state => ({
    messages:             state.messages.messagesOfSelectedContact,
    selectedContactId:    state.selectedContact.id,
    startPointMessageId:  state.messages.startPointMessageId,
    allOldMessagesLoaded: state.messages.allOldMessagesLoaded
  }), 
  dispatch => ({
    updateFriendList: () => {
      dispatch( getFriends() );
    },
    updateGroupList: () => {
      dispatch( getGroups() );
    },
    addNewMessageToList: message => {
      dispatch( addNewMessageToList(message) );
    },
    getMoreOldMessages: (contactId, numberScrollLoad, startPointMessageId) => {
      dispatch( getMoreOldMessages(contactId, numberScrollLoad, startPointMessageId) );
    },
    resetAllMessagesLoaded: () => {
      dispatch({ type: 'RESET_ALL_OLD_MESSAGES_LOADED' });
    }
  })
)(MessageList);