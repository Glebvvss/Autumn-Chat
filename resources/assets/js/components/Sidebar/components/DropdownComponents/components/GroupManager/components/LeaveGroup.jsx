import React, { Component } from 'react';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import ReactScrollbar from 'react-scrollbar-js';
import { connect } from 'react-redux';
import { leaveGroup } from '../../../../../../../actions/groups.js';

const scrollbar = {
  width: 260,
  height: '100%',
};

class LeaveGroup extends Component {

  constructor(props) {
    super(props);
    this.state = {
      visibleComponent: {
        left: 0
      },
      groupName: '',
    };
  }

  initialLeaveGroup() {
    this.props.leaveGroup(this.props.selectedGroupId);
  }

  renderIfGroupSelected() {
    return (
      <div className="update-selected-group">
        <button className="add-checked-friends-to-group"
                onClick={this.initialLeaveGroup.bind(this)}>
                
          Leave Selected Group
        </button>
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
    if ( this.props.selectedGroupId !== null ) {
      return this.renderIfGroupSelected();
    }
    return this.renderIfGroupNoSelected();
  }

}

export default connect(
  state => ({
    selectedGroupId: state.selectedContact.id
  }),
  dispatch => ({
    leaveGroup: groupId => {
      dispatch(leaveGroup(groupId));
    }
  })
)(LeaveGroup);