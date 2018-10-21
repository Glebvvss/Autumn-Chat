import React, { Component } from 'react';
import { connect } from 'react-redux';
import { makeUriForRequest } from '../../../../../functions.js';
import { getMessagesOfGroup } from '../../../../../actions/messages';
import { getGroups, 
         getMembersOfGroup, 
         getFriendsWhoNotInGroup } from '../../../../../actions/groups';

class Groups extends Component {

  constructor(props) {
    super(props);
    this.props.getGroups();
  }

  socketMethod() {
    fetch( makeUriForRequest('/get-user-id'), {
      method: 'get'
    }).then(response => {
      response.json().then(httpData => {
        let socket = io(':3001'),
            userId = httpData.userId,
            room   = 'friends-by-user-id:' + userId;

        socket.on(room, (socketData) => {
          
        });
      });
    });
  }

  componentDidUpdate(prevProps) {
    if ( this.props !== prevProps ) {
      
    }
  }

  selectGroup(event) {
    const selectedGroupId = event.target.attributes['data-id']['value'];

    this.props.setSelectedGroupParams(selectedGroupId);
    this.props.getMembersOfGroup(selectedGroupId);
    this.props.getMessagesOfGroup(selectedGroupId);
    this.props.getFriendsWhoNotInGroup(selectedGroupId);
  }

  render() {
    return (
      <ul>
        {
          this.props.groups.map((item, index) => (
            <li key={index}
                data-id={item.id}
                onClick={this.selectGroup.bind(this)} 
                className={( this.props.selectedContactId == item.id ) ? 'active-contact' : null} >
              
              {item.group_name}
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
    selectedContactId:            state.selectedContact.id,
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
    getMessagesOfGroup: groupId => {
      dispatch( getMessagesOfGroup(groupId) );
    },
  })
)(Groups);