import React, { Component } from 'react';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import ReactScrollbar from 'react-scrollbar-js';
import { connect } from 'react-redux';
import FriendList from './components/FriendList';

import { createGroup } from '../../../../../../actions/groups.js';

const scrollbar = {
  width: 260,
  height: '100%',
};

class GroupManager extends Component {

  constructor(props) {
    super(props);
    this.state = {
      visibleComponent: {
        left: 0
      },
      groupMemberList: [],
      groupName: '',
    };
  }

  componentDidUpdate(prevProps, prevState, snapshot) {
    if ( this.props !== prevProps ) {
      this.checkVisibleStatusFriendShipRequests();
      this.resetGroupMemberListIfGroupCreated();
    }
  }

  resetGroupMemberListIfGroupCreated() {
    if ( this.props.notification === 'Group created!' ) {
      let elementList = document.querySelectorAll('span.added-top-group-friend');

      elementList.forEach((element) => {
        element.style.opacity = '';
      });
    
      this.state.groupMemberList = [];
    }
  }

  checkVisibleStatusFriendShipRequests() {
    if ( this.props.visible === true ) {
      this.setState({
        ...this.state,
        visibleComponent: {
          left: '260px'
        }
      });
    } else {
      this.setState({
        ...this.state,
        visibleComponent: {
          left: 0
        }
      });
    }
  }

  addFriendToGroup(event) {
    this.addOrRomoveCheckMarker(event);
    this.updateListOfGroupMembers(event);
  }

  updateListOfGroupMembers(event) {
    let id = event.target.attributes['data-userID'];
    if ( this.state.groupMemberList.indexOf(id.value) === -1 ) {
      this.state.groupMemberList.push(id.value);
    } else {
      const elementToDelete = this.state.groupMemberList.indexOf(id.value);
      this.state.groupMemberList.splice(elementToDelete, 1);
    }
  }

  handleInput(event) {
    this.setState({
      ...this.state,
      groupName: event.target.value
    });
  }

  addOrRomoveCheckMarker(event) {
    let span = event.target.children[0];
    if ( span.style.opacity === '' ) {
      span.style.opacity = '1';
    } else {
      span.style.opacity = '';
    }
  }

  initialCreateGroup() {
    this.props.createGroup(this.state.groupName, { list: this.state.groupMemberList });
  }

  render() {
    return (
      <div className="group-manager-block" style={this.state.visibleComponent}>
        <input  className="new-group-name"
                onChange={this.handleInput.bind(this)}
                value={this.state.groupName}
                placeholder="New Group Name" />

        <button className="create-group" 
                onClick={this.initialCreateGroup.bind(this)}>

          Cheate Group
        </button>

        <ReactScrollbar style={scrollbar}>
          <div className="list-select-member-to-group">
            <ul>
              {
                this.props.friends.map((item, index) => (
                  <li key={index} 
                      data-userID={item.id}
                      onClick={this.addFriendToGroup.bind(this)}>

                    {item.username}
                    <span className="added-top-group-friend">
                      <FontAwesomeIcon icon="check-circle" />
                    </span>
                  </li>
                ))
              }
            </ul>
          </div>
        </ReactScrollbar>

      </div>
    );
  }

}

export default connect(
  state => ({
    visible: state.sidebarDropdownElements.groupManagerVisible,
    friends: state.friends.friends,
    notification: state.notification.message,
  }),
  dispatch => ({
    createGroup: (groupName, userListOfGroup) => {
      dispatch(createGroup(groupName, userListOfGroup));
    }
  })
)(GroupManager);