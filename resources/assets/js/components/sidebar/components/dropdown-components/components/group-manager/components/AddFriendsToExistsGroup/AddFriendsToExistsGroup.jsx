import React, { Component } from 'react';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import ReactScrollbar from 'react-scrollbar-js';
import { connect } from 'react-redux';

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

  renderIfGroupSelected() {
    return (
      <div className="update-selected-group">
        <div>
          <button className="add-checked-friends-to-group">
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
    if ( this.props.selectedGroupId === null ) {
      return this.renderIfGroupNoSelected();
    }
    return this.renderIfGroupSelected();
  }

}

export default connect(
  state => ({
    groupMembersIdList: state.makeNewGroup.groupMembersIdList,
    friendsWhoNotInSelectedGroup: state.selectedGroup.friendsWhoNotInSelectedGroup,
    selectedGroupId: state.selectedGroup.selectedGroupId,
  }),
  dispatch => ({

  })
)(AddFriendsToExistsGroup);