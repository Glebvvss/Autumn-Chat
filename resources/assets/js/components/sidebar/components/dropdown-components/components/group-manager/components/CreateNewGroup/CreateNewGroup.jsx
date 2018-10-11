import React, { Component } from 'react';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import ReactScrollbar from 'react-scrollbar-js';
import { connect } from 'react-redux';
import { createGroup } from '../../../../../../../../actions/groups.js';
import FriendListForCreateGroup from './components/FriendListForCreateGroup';

const scrollbar = {
  width: 260,
  height: '100%',
};

class CreateNewGroup extends Component {

  constructor(props) {
    super(props);
    this.state = {
      visibleComponent: {
        left: 0
      },
      groupName: '',
    };
  }

  initialCreateGroup() {
    this.props.createGroup(this.state.groupName, this.props.groupMembersIdList);
  }

  handleInput(event) {
    this.setState({
      ...this.state,
      groupName: event.target.value
    });
  }

  render() {
    return (
      <div className="make-new-group">
        <input  className="new-group-name"
                onChange={this.handleInput.bind(this)}
                value={this.state.groupName}
                placeholder="New Group Name" />

        <button className="create-group"
                onClick={this.initialCreateGroup.bind(this)} >

          Cheate Group
        </button>

        <ReactScrollbar style={scrollbar}>
          <FriendListForCreateGroup />
        </ReactScrollbar>      
      </div>
    );
  }

}

export default connect(
  state => ({
    friends: state.friends.friends,
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
)(CreateNewGroup);