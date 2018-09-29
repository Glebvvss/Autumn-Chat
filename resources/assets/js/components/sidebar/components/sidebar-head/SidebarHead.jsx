import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import { connect } from 'react-redux';
import { logoutAction, getUsername } from '../../../../actions/auth';
import { getFriendshipRequests } from '../../../../actions/friends';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';        
import FriendshipRequests from './components/FriendshipRequests/FriendshipRequests'

class SidebarHead extends Component {

  constructor(props) {
    super(props);
    this.props.getUsername();
    this.state = {
      friendshipRequestListUpdated: false,
      visibleFriendshipRequests: false,
      visibleGroupMaker: false,
      changesMarkerStyles: {
        opacity: 0
      }
    };
    this.hideIfClickWasOutComponent();
  }

  componentDidUpdate(prevProps) {
    if (this.props !== prevProps) {

      if ( this.state.visibleFriendshipRequests === false &&
           this.props.friendshipRequests.toString() !==
           prevProps.friendshipRequests.toString() ) {

        this.setState({
          ...this.state,
          changesMarkerStyles: {
            opacity: 1
          }
        });
      } else {
        this.setState({
          ...this.state,
          changesMarkerStyles: {
            opacity: 0
          }
        });
      }

    }
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
     //if ( ReactDOM.findDOMNode(this) ) {}
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

          <div className="update-marker-friendship-list" style={this.state.changesMarkerStyles}></div>

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
    user: state.userInfo,
    friendshipRequests: state.friends.friendshipRequests
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