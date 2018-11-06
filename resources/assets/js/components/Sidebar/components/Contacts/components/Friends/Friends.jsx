import React, { Component } from 'react';
import { connect } from 'react-redux';
import DeleteFromFriends from './components/DeleteFromFriends.jsx';

import { getLastMessagesOfDialog } from '../../../../../../actions/messages';

import { dropUnreadMessageLink,
         dropUnreadMessageLinkOfDialog } from '../../../../../../actions/messages';

import { scrfToken, 
         makeUriForRequest } from '../../../../../../functions.js';

import { getFriends, 
         setDialogId,
         deleteFromFriendList } from '../../../../../../actions/friends';

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

  deleteFromFriends() {
    this.props.deleteFromFriendList();
  }

  render() {
    return (
      <ul>
        {
          this.props.friends.map((item, index) => (
            <li key={index}>
              <span className="friend-name"
                    data-friendID={item.id}
                    onClick={this.selectDialog.bind(this)}
                    className={( this.state.selectedFriendId    ==  item.id    &&
                                 this.props.selectedContactType === 'DIALOG' ) ?
                                 'active-contact friend-name' : 'friend-name'}>

                {item.username}
                <UnreadMessageMarker exists={item.unread_message_exists} />
              </span>

              <OnlineStatus onlineStatus={item.online} />
              <DeleteFromFriends friendId={item.id}  />
            </li> ))
        }
      </ul>
    );
  }

}

function UnreadMessageMarker(props) {
  if ( props.exists === true ) {
    return (
      <div className="notice-new">NEW</div>
    );
  } else {
    return (
      <span></span>
    );
  }
}

function OnlineStatus(props) {
  if ( props.onlineStatus === true ) {
    return (
      <div className="online-status"></div>
    );
  } else {
    return (
      <div className="offline-status"></div>
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
    },
    deleteFromFriendList: friendId => {
      dispatch( deleteFromFriendList(friendId) );
    }
  })
)(Friends);