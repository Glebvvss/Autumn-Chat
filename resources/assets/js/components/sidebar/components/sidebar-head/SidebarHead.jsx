import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import { connect } from 'react-redux';
import { logoutAction, getUsername } from '../../../../actions/auth';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';        
import FriendshipRequests from './components/FriendshipRequests/FriendshipRequests'
import { getFriendshipRequests, 
         readNewRecivedFriendshipRequests,
         getCountNewRecivedFriendshipRequests } from '../../../../actions/friends';

class SidebarHead extends Component {

  constructor(props) {
    super(props);
    this.props.getUsername();
    this.props.getCountNewRecivedFriendshipRequests();

    this.state = {
      visibleFriendshipRequests: false,
      changesMarkerStyles: {
        opacity: 0
      }
    };
  }

  componentDidUpdate(prevProps) {
    if (this.props !== prevProps) {
      this.checkUnreadRecivedFriendshipRequests();
    }
  }

  checkUnreadRecivedFriendshipRequests() {
    if ( this.props.countNewRecivedFriendshipRequests !== 0 ) {
      this.setState({
        changesMarkerStyles: {
          opacity: 1
        }  
      });
    } else {
      this.setState({
        changesMarkerStyles: {
          opacity: 0
        }  
      });
    }
  }

  hideOrShowFriendshipRequests() {
    if ( this.state.visibleFriendshipRequests === false ) {
      this.props.readNewRecivedFriendshipRequests();
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
    countNewRecivedFriendshipRequests: state.friendshipRequests.countNewRecived
  }),
  dispatch => ({
    logoutAction: () => {
      dispatch(logoutAction());
    },
    getUsername: () => {
      dispatch(getUsername());
    },
    getCountNewRecivedFriendshipRequests: () => {
      dispatch(getCountNewRecivedFriendshipRequests());
    },
    readNewRecivedFriendshipRequests: () => {
      dispatch(readNewRecivedFriendshipRequests());
    }
  })
)(SidebarHead);