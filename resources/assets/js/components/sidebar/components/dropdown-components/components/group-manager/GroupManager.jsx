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

let groupMemberList = [];

class GroupManager extends Component {

  constructor(props) {
    super(props);
    this.state = {
      visibleComponent: {
        left: 0
      },
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
    let clickedFriendId = event.target.attributes['data-userID']['value'];
    this.props.changeFroupMemberList(clickedFriendId);
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
    this.props.createGroup(this.state.groupName, this.props.groupMembersIdList);
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
    groupMembersIdList: state.makeNewGroup.groupMembersIdList,
  }),
  dispatch => ({
    createGroup: (groupName, groupMembersIdList) => {
      dispatch(createGroup(groupName, groupMembersIdList));
    },
    changeFroupMemberList: (clickedFriendId) => {
      dispatch({ type: 'CHANGE_GROUP_MEMBER_LIST_BEFORE_CREATED', payload: clickedFriendId });
    }
  })
)(GroupManager);