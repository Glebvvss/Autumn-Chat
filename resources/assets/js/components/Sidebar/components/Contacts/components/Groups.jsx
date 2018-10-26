import React, { Component } from 'react';
import { connect } from 'react-redux';
import { makeUriForRequest } from '../../../../../functions.js';

import { getLatestMessages,
         dropUnreadMessageLink } from '../../../../../actions/messages';

import { getGroups, 
         getMembersOfGroup, 
         getFriendsWhoNotInGroup } from '../../../../../actions/groups';

class Groups extends Component {

  constructor(props) {
    super(props);
    this.props.getGroups();
    this.subscribeOnChangesInGroupList();

    this.state = {
      selectedGroupId: null
    };
  }

  subscribeOnChangesInGroupList() {
    fetch( makeUriForRequest('/get-user-id'), {
      method: 'get'
    }).then(response => {
      response.json().then(httpData => {
        let socket = io(':3001'),
            userId = httpData.userId,
            room   = 'update-group-list:' + userId;

        socket.on(room, (socketData) => {
          this.props.getGroups();
        });
      });
    });
  }

  componentDidUpdate(prevProps) {
    if ( this.props !== prevProps ) {
      
    }
  }

  highlightSelectedGroup(groupId) {
    this.setState({
      ...this.state,
      selectedGroupId: groupId
    });
  }

  selectGroup(event) {
    const selectedGroupId = event.target.attributes['data-id']['value'];

    this.props.setSelectedGroupParams(selectedGroupId);
    this.props.getMembersOfGroup(selectedGroupId);
    this.props.getFriendsWhoNotInGroup(selectedGroupId);
    this.props.getLatestMessages(selectedGroupId);
    this.props.dropUnreadMessageLink(selectedGroupId);
    this.highlightSelectedGroup(selectedGroupId);
  }

  renderIfHaveUnreadMessagesMarker(item) {
    if ( item.unread_message_exists === true ) {
      return (
        <div className="notice-new">NEW</div>
      );
    }
  }

  render() {
    return (
      <ul>
        {
          this.props.groups.map((item, index) => (
            <li key={index}
                data-id={item.id}
                onClick={this.selectGroup.bind(this)} 
                className={( this.state.selectedGroupId     == item.id &&
                             this.props.selectedContactType == 'GROUP' ) ? 'active-contact' : null} >
              
              {item.group_name}
              {this.renderIfHaveUnreadMessagesMarker(item)}
            </li> ))
        }
      </ul>
    );
  }

}

export default connect(
  state => ({
    groups:                       state.groups.groups,
    membersOfGroup:               state.selectedContact.members,
    selectedContactType:          state.selectedContact.type,
    friendsWhoNotInSelectedGroup: state.selectedContact.friendsWhoNotInSelectedContact,
  }),
  dispatch => ({
    getFriendsWhoNotInGroup: groupId => {
      dispatch(getFriendsWhoNotInGroup(groupId));
    },
    getGroups: () => {
      dispatch(getGroups());
    },
    getMembersOfGroup: groupId => {
      dispatch(getMembersOfGroup(groupId));
    },
    setSelectedGroupParams: groupId => {
      dispatch({ type: 'SET_SELECTED_CONTACT_ID',   payload: groupId });
      dispatch({ type: 'SET_SELECTED_CONTACT_TYPE', payload: 'GROUP' });
    },
    getLatestMessages: groupId => {
      dispatch( getLatestMessages(groupId) );
    },
    dropUnreadMessageLink: groupId => {
      dispatch( dropUnreadMessageLink(groupId) );
    }
  })
)(Groups);