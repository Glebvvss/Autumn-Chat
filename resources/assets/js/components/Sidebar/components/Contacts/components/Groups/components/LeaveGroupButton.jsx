import React, { Component } from 'react';
import { connect } from 'react-redux';
import { leaveGroup } from '../../../../../../../actions/groups.js';

class LeaveGroupButton extends Component {
  constructor(props) {
    super(props);
  }

  initialLeaveGroup(event) {
    let groupId = event.target.attributes['data-groupID']['value'];
    let result = confirm('Are You Want To Leave Public Group?');

    if ( result === true ) {
      this.props.leaveGroup(groupId);
    }
  }

  render() {
    return (
      <div className="leave-public-group"
           data-groupID={this.props.groupId}
           onClick={this.initialLeaveGroup.bind(this)}>

        leave
      </div>
    );
  }
}

export default connect(
  state => ({
    
  }),
  dispatch => ({
    leaveGroup: groupId => {
      dispatch( leaveGroup(groupId) );
    }
  })
)(LeaveGroupButton);