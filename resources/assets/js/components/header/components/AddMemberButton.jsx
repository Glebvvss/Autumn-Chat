import React, { Component } from 'react';
import { connect } from 'react-redux';

class AddMemberButton extends Component {

  constructor(props) {
    super(props);
  }

  render() {
    return (
      <button className="button-right">Add Member</button>
    );
  }

}

export default AddMemberButton;