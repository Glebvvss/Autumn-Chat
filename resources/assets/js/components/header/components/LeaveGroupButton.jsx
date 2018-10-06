import React, { Component } from 'react';
import { connect } from 'react-redux';

class LeaveGroupButton extends Component {

  constructor(props) {
    super(props);
  }

  render() {
    return (
      <button className="button-right">Leave</button>
    );
  }

}

export default LeaveGroupButton;