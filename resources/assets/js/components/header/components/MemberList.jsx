import React, { Component } from 'react';

class MemberList extends Component {

  constructor(props) {
    super(props);
  }

  render() {
    return (
      <div className="members">
        <ul className="user-list-of-group">
          <li>Members:</li>
          <li>Username</li>
          <li>Username</li>
          <li>Username</li>
          <li>Username</li>
          <li>Username</li>
          <li>Username</li>
          <li>Username</li>
          <li>...</li>
        </ul>
      </div>
    );
  }

}

export default MemberList;