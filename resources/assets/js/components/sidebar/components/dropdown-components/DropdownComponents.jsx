import React, { Component } from 'react';
import FrienshipRequests from './components/friendship-requests/FriendshipRequests';

class DropdownComponents extends Component {

  constructor(props) {
    super(props);
  }

  render() {
    return (
      <div>
        <FrienshipRequests />
      </div>
    );
  }

}

export default DropdownComponents;