import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import { connect } from 'react-redux';
import { logoutAction, getUsername } from '../../../../actions/auth';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';        

class SidebarHead extends Component {

  constructor(props) {
    super(props);
    this.props.getUsername();

    this.state = {
      visibleFriendshipRequests: false,
      changesMarkerStyles: {
        opacity: 0
      }
    };
  }

  componentDidUpdate(prevProps) {
    if (this.props !== prevProps) {
      
    }
  }

  render() {
    return (
      <div className="sidebar-head">
        <h1 className="username">{this.props.user.username}</h1>
        <div className="logout" onClick={this.props.logoutAction}>logout</div>
        <div className="icons">

          <span>
            <FontAwesomeIcon icon="comment" />
          </span>

          <div className="update-marker-friendship-list" style={this.state.changesMarkerStyles}></div>

          <span onClick={this.props.changeVisibleFriendshipRequests}>
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
    countNewRecivedFriendshipRequests: state.friendshipRequests.countNewRecived,    
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
    }
  })
)(SidebarHead);