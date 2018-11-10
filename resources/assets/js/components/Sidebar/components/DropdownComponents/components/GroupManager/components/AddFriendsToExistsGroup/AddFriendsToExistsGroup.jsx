import React, { Component } from 'react';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import ReactScrollbar from 'react-scrollbar-js';
import { connect } from 'react-redux';
import { addSelectedMembersToGroup } from '../../../../../../../../actions/groups';
import FriendListForExistsGroup from './components/FriendListForExistsGroup';

const scrollbar = {
  width: 260,
  height: '100%',
};

class AddFriendsToExistsGroup extends Component {

  constructor(props) {
    super(props);
    this.state = {
      visibleComponent: {
        left: 0
      },
      groupName: '',
    };
  }

  initialAddSelectedFriendsToGroup() {
    this.props.addSelectedMembersToGroup(
      this.props.selectedContactId, 
      this.props.newMembersIdToGroup
    );
  }

  renderIfGroupSelected() {
    return (
      <div className="update-selected-group">
        <div>
          <button className="add-checked-friends-to-group"
                  onClick={this.initialAddSelectedFriendsToGroup.bind(this)}>

            Add
          </button>
          
          <ReactScrollbar style={scrollbar}>
            <FriendListForExistsGroup />
          </ReactScrollbar>
        </div>
      </div>
    );
  }

  renderIfGroupNoSelected() {
    return (
      <div>
        <p className="group-no-selected-text">Group is not selected!</p>
      </div>
    );
  }

  render() {
    if ( this.props.selectedContactId   !== null   && 
         this.props.selectedContactType === 'GROUP' ) {

      return this.renderIfGroupSelected();
    }
    return this.renderIfGroupNoSelected();
  }

}

export default connect(
  state => ({
    groupMembersIdList:           state.makeNewGroup.groupMembersIdList,
    selectedContactId:            state.selectedContact.id,
    selectedContactType:          state.selectedContact.type,
    newMembersIdToGroup:          state.selectedContact.newMembersIdToContact,
    friendsWhoNotInSelectedGroup: state.selectedContact.friendsWhoNotInSelectedContact,
  }),
  dispatch => ({
    addSelectedMembersToGroup: (groupId, newGroupMembersIdList) => {
      dispatch( addSelectedMembersToGroup(groupId, newGroupMembersIdList) );
    }
  })
)(AddFriendsToExistsGroup);