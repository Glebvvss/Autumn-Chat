import React, { Component } from 'react';
import { connect } from 'react-redux';
import { makeUriForRequest } from '../../../../../functions.js';
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

  highlightActiveItem() {
    
  }

  selectGroup(event) {
    const selectedGroupId = event.target.attributes['data-id']['value'];

    this.props.getFriendsWhoNotInGroup(selectedGroupId);
    this.props.setSelectedGroupId(selectedGroupId);
    this.props.getMembersOfGroup(selectedGroupId);   
  }

  render() {
    return (
      <ul>
        {
          this.props.groups.map((item, index) => (
            <li key={index}
                data-id={item.id}
                onClick={this.selectGroup.bind(this)} >
                
              {item.group_name}
            </li>
          ))
        }
      </ul>
    );
  }

}

export default connect(
  state => ({
    groups:                       state.groups.groups,
    membersOfGroup:               state.selectedGroup.membersOfSelectedGroup,
    friendsWhoNotInSelectedGroup: state.selectedGroup.friendsWhoNotInSelectedGroup,
  }),
  dispatch => ({
    getFriendsWhoNotInGroup: (groupId) => {
      dispatch(getFriendsWhoNotInGroup(groupId));
    },
    getGroups: () => {
      dispatch(getGroups());
    },
    getMembersOfGroup: (groupId) => {
      dispatch(getMembersOfGroup(groupId));
    },
    setSelectedGroupId: (groupId) => {
      dispatch({ type: 'SET_SELECTED_GROUP_ID', payload: groupId });
    }
  })
)(Groups);