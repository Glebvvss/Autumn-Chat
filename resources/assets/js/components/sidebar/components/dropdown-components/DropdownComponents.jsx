import React, { Component } from 'react';
import FrienshipRequests from './components/friendship-requests/FriendshipRequests';
import GroupManager from './components/group-manager/GroupManager';

class DropdownComponents extends Component {

  constructor(props) {
    super(props);
  }

  render() {
    return (
      <div>
        <FrienshipRequests />
        <GroupManager />
      </div>
    );
  }

}

export default DropdownComponents;