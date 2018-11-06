import React, { Component } from 'react';
import { connect } from 'react-redux';
import { getMembersOfGroup } from '../../../actions/groups.js';

class MemberList extends Component {

  constructor(props) {
    super(props);
  }

  subscribeOnChangesInMemberList() {
    let socket = io(':3001'),
        room   = 'update-members-of-public-group:' + this.props.selectedContactId;

    socket.on(room, (socketData) => {
      this.props.getMembersOfGroup(this.props.selectedContactId);
    });
  }

  render() {
    this.subscribeOnChangesInMemberList();
    return (
      <div className={ this.props.selectedContactType != 'GROUP' ? 'hide member-list' : 'member-list' }>

        <h1>Members: </h1>
        <ul>
          {
            this.props.members.map((item, index) => (
              <li>{item.username}</li>
            ))
          }
        </ul>
      </div>
    );
  }
}

export default connect(
  state => ({
    members:             state.selectedContact.members,
    selectedContactType: state.selectedContact.type,
    selectedContactId:   state.selectedContact.id
  }),
  dispatch => ({
    getMembersOfGroup: (groupId) => {
      dispatch( getMembersOfGroup(groupId) );
    }
  })
)(MemberList);