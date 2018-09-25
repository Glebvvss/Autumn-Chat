import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import { connect } from 'react-redux';
import { logoutAction, getUsername } from '../../../../actions/auth';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';        
import FriendshipRequests from './components/FriendshipRequests'

class SidebarHead extends Component {

  constructor(props) {
    super(props);
    this.props.getUsername();
    this.state = {
      visibleFriendshipRequests: false,
      visibleGroupMaker: false
    };
    this.hideIfClickWasOutComponent();
  }

  hideOrShowFriendshipRequests() {
    if ( this.state.visibleFriendshipRequests === false ) {
      this.setState({
        ...this.state,
        visibleFriendshipRequests: true
      });
    } else {
      this.setState({
        ...this.state,
        visibleFriendshipRequests: false
      });
    }
  }

  hideIfClickWasOutComponent(event) {
    document.addEventListener('click', (event) => {
     if ( ReactDOM.findDOMNode(this) ) {}
    });
  }

  initialLogoutAction() {
    this.props.logoutAction();
  }

  render() {
    return (
      <div className="sidebar-head">
        <h1 className="username">{this.props.user.username}</h1>
        <div className="logout" onClick={this.initialLogoutAction.bind(this)}>logout</div>
        <div className="icons">

          <span>
            <FontAwesomeIcon icon="comment" />
          </span>

          <span onClick={this.hideOrShowFriendshipRequests.bind(this)}>
            <FontAwesomeIcon icon="user-friends" />
          </span>

        </div>
        <FriendshipRequests visible={this.state.visibleFriendshipRequests} />
      </div>
    );
  }

}

export default connect(
  state => ({
    user: state.userInfo
  }),
  dispatch => ({
    logoutAction: () => {
      dispatch(logoutAction());
    },
    getUsername: () => {
      dispatch(getUsername());
    }
  })
)(SidebarHead);