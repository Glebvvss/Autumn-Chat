import React, { Component } from 'react';
import { connect } from 'react-redux';
import { getMessages } from '../../../../../actions/messages';
import { scrfToken, makeUriForRequest } from '../../../../../functions.js';

import { getFriends, 
         getDialogIdAndGetMessagesOfDialog } from '../../../../../actions/friends';

class Friends extends Component {

  constructor(props) {
    super(props);
    this.props.getFriends();
    this.subscribeOnChangesInFreindList();

    this.state = {
      selectedFriendId: null
    };
  }

  subscribeOnChangesInFreindList() {
    fetch( makeUriForRequest('/get-user-id'), {
      method: 'get'
    }).then(response => {
      response.json().then(httpData => {
        let socket = io(':3001'),
            userId = httpData.userId,
            room   = 'friends-by-user-id:' + userId;

        socket.on(room, (socketData) => {
          this.props.getFriends();
        });
      });
    });
  }

  componentDidUpdate(prevProps) {
    if ( this.props !== prevProps && 
         this.props.selectedContactType !== 'DIALOG' ) {

      this.resetHighlightMarkers();
    }
  }

  resetHighlightMarkers() {
    this.setState({
      ...this.state,
      selectedFriendId: null
    });
  }

  highlightSelectedFriend(friendId) {
    this.setState({
      ...this.state,
      selectedFriendId: friendId
    });
  }

  selectDialog(event) {
    let friendId = event.target.attributes['data-friendID']['value'];

    this.props.getDialogIdAndGetMessagesOfDialog(friendId);
    this.highlightSelectedFriend(friendId);
  }

  renderNewStatus(newStatus) {
    if ( newStatus === 1 ) {
      return (
        <div className="notice-new">NEW</div>
      );
    }
  }

  renderOnlineStatus(onlineStatus) {
    if ( onlineStatus === 1 ) {
      return (
        <div className="online-status"></div>
      );
    } else {
      return (
        <div className="offline-status"></div>
      );
    }
  }

  render() {
    return (
      <ul>
        {
          this.props.friends.map((item, index) => (
            <li key={index}
                data-friendID={item.id}
                onClick={this.selectDialog.bind(this)}
                className={( this.state.selectedFriendId == item.id &&
                             this.props.selectedContactType === 'DIALOG' ) ? 'active-contact' : null} >

              {item.username}
              <div className="right-contacts-li-element">
                {this.renderOnlineStatus(item.online)}
              </div>
            </li> ))
        }
      </ul>
    );
  }

}

export default connect(
  state => ({
    friends:             state.friends.friends,
    selectedContactId:   state.selectedContact.id,
    selectedContactType: state.selectedContact.type,
  }),
  dispatch => ({
    getFriends: () => {
      dispatch(getFriends());
    },
    getMessages: dialogId => {
      dispatch( getMessages(dialogId) );
    },
    getDialogIdAndGetMessagesOfDialog: friendId => {
      dispatch( getDialogIdAndGetMessagesOfDialog(friendId) );
      dispatch({ type: 'SET_SELECTED_CONTACT_TYPE', payload: 'DIALOG' });
    },
  })
)(Friends);