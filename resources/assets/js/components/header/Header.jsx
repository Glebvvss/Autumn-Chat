import React, { Component } from 'react';
import { connect } from 'react-redux';

class Header extends Component {

  constructor(props) {
    super(props);
  }

  render() {
    return (
      <header className="fixed-header">
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
        <div className="header-right-buttons">
          <button className="button-right">Add Member</button>
          <button className="button">Leave</button>
        </div>
      </header>
    )
  }

}

export default Header