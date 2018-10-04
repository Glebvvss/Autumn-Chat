import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import { connect } from 'react-redux';
import { logoutAction, getUsername } from '../../../../actions/auth';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { getCountNewRecivedFriendshipRequests,
         readNewRecivedFriendshipRequests } from '../../../../actions/friends';

class SidebarHead extends Component {

  constructor(props) {
    super(props);
    this.props.getUsername();
    this.props.getCountNewRecivedFriendshipRequests();

    this.state = {
      visibleFriendshipRequests: false,
      visibleRequestsMarker: {
        opacity: 0
      }
    };
  }

  componentDidUpdate(prevProps) {
    if (this.props !== prevProps) {
      this.showMarkIfHaveNewRequests();
    }
  }

  showMarkIfHaveNewRequests() {
    if ( this.props.haveNewRequests === 0 ) {
      this.setState({
        ...this.state,
        visibleRequestsMarker: {
          opacity: 0
        }
      });
    } else if ( this.props.haveNewRequests > 0 ) {
      this.setState({
        ...this.state,
        visibleRequestsMarker: {
          opacity: 1
        }
      });
    }
  }

  changeVisibleFriendshipRequests() {
    this.props.readNewRecivedFriendshipRequests()
    this.props.changeVisibleFriendshipRequests();
  }

  render() {
    console.log(this.props.haveNewRequests);
    return (
      <div className="sidebar-head">
        <h1 className="username">{this.props.user.username}</h1>
        <div className="logout" onClick={this.props.logoutAction}>logout</div>
        <div className="icons">

          <span onClick={this.props.changeVisibleGroupManager}>
            <FontAwesomeIcon icon="comment" />
          </span>

          <div className="update-marker-friendship-list" 
               onClick={this.props.readNewRecivedFriendshipRequests}
               style={this.state.visibleRequestsMarker}>
          </div>
          <span onClick={this.changeVisibleFriendshipRequests.bind(this)}>
            <FontAwesomeIcon icon="user-friends" />
          </span>

        </div>
      </div>
    );
  }

}

export default connect(
  state => ({
    user: state.userInfo,
    haveNewRequests: state.friendshipRequests.countNewRecived,
  }),
  dispatch => ({
    logoutAction: () => {
      dispatch(logoutAction());
    },
    getUsername: () => {
      dispatch(getUsername());
    },
    changeVisibleFriendshipRequests: () => {
      dispatch({ type: 'CHANGE_VISIBLE_STATUS_FRIENSHIP_REQUESTS' });
    },
    changeVisibleGroupManager: () => {
      dispatch({ type: 'CHANGE_VISIBLE_STATUS_GROUP_MANAGER' });
    },
    getCountNewRecivedFriendshipRequests: () => {
      dispatch(getCountNewRecivedFriendshipRequests());
    },
    readNewRecivedFriendshipRequests: () => {
      dispatch(readNewRecivedFriendshipRequests());
    }
  })
)(SidebarHead);