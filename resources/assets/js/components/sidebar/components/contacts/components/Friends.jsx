import React, { Component } from 'react';
import { connect } from 'react-redux';
import { getFriends } from '../../../../../actions/friends';

class Friends extends Component {

  constructor(props) {
    super(props);
    this.props.getFriends();
  }

  highlightActiveItem() {
    
  }

  openDialog() {

  }

  renderNewStatus(newStatus) {
    if ( newStatus === 1 ) {
      return (
        <div className="notice-new">NEW</div>
      );
    }
  }

  renderOnlineStatus(onlineStatus) {
    if ( onlineStatus === 1 ) {
      return (
        <div className="online-status"></div>
      );
    } else {
      return (
        <div className="offline-status"></div>
      );
    }
  }

  render() {
    return (
      <ul>
        {
          this.props.friends.map((item, index) => (
            <li key={index} 
                onClick={this.openDialog.bind(this)}
                className="active-connect">

              {item.user_friend.username}

              <div className="right-contacts-li-element">
                {this.renderOnlineStatus(item.user_friend.online)}
                {this.renderNewStatus(item.new)}
              </div>

            </li>
          ))
        }
      </ul>
    );
  }

}

export default connect(
  state => ({
    friends: state.friends.friends
  }),
  dispatch => ({
    getFriends: () => {
      dispatch(getFriends());
    }
  })
)(Friends);