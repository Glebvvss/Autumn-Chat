import React, { Component } from 'react';

class GroupManager extends Component {

  constructor(props) {
    super(props);
  }

  render() {
    return (
      <div className="group-manager-block">
        <input className="new-group-name" 
               placeholder="New Group Name" />

        <button className="create-group">Cheate Group</button>

        <div className="list-select-member-to-group">
          <ul>
            <li>Username</li>
          </ul>
        </div>
      </div>
    );
  }

}

export default GroupManager;