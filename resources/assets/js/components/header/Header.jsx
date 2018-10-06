import React, { Component } from 'react';
import { connect } from 'react-redux';
import MemberList from './components/MemberList';
import AddMemberButton from './components/AddMemberButton';
import LeaveGroupButton from './components/LeaveGroupButton';

class Header extends Component {

  constructor(props) {
    super(props);
  }

  render() {
    return (
      <header className="fixed-header">
        <MemberList />
        <div className="header-right-buttons">
          <AddMemberButton />
          <LeaveGroupButton />
        </div>
      </header>
    )
  }

}

export default Header;