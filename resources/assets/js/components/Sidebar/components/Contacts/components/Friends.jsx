import React, { Component } from 'react';
import { connect } from 'react-redux';
import { getLastMessagesOfDialog } from '../../../../../actions/messages';
import { dropUnreadMessageLink,
         dropUnreadMessageLinkOfDialog } from '../../../../../actions/messages';

import { scrfToken, 
         makeUriForRequest } from '../../../../../functions.js';

import { getFriends, 
         setDialogId } from '../../../../../actions/friends';

class Friends extends Component {

  constructor(props) {
    super(props);
    this.props.getFriends();
    this.subscribeOnChangesInFreindList();

    this.state = {
      selectedFriendId: 2
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

  highlightSelectedFriend(friendId) {
    console.log(friendId);
    this.setState({
      ...this.state,
      selectedFriendId: friendId
    });
  }

  selectDialog(event) {
    let friendId = event.target.attributes['data-friendID']['value'];

    this.props.setDialogId(friendId);
    this.props.setTypeOfSelectedContact();
    this.props.getLastMessagesOfDialog(friendId);
    this.props.dropUnreadMessageLinkOfDialog(friendId);
    this.highlightSelectedFriend(friendId);
  }

  renderIfHaveUnreadMessagesMarker(item) {
    if ( item.unread_message_exists === true ) {
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
              {this.renderIfHaveUnreadMessagesMarker(item)}

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
    dropUnreadMessageLinkOfDialog: friendId => {
      dispatch( dropUnreadMessageLinkOfDialog(friendId) );
    },
    getLastMessagesOfDialog: friendId => {
      dispatch( getLastMessagesOfDialog(friendId) );
    },
    setDialogId: friendId => {
      dispatch( setDialogId(friendId) );
    },
    setTypeOfSelectedContact: () => {
      dispatch({ type: 'SET_SELECTED_CONTACT_TYPE', payload: 'DIALOG' });
    }
  })
)(Friends);