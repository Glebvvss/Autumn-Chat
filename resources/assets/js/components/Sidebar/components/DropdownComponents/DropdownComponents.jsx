import React, { Component } from 'react';

import FrienshipRequests from './components/FriendshipRequests/FriendshipRequests.jsx';
import GroupManager from './components/GroupManager/GroupManager.jsx';

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