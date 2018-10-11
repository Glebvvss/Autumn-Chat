import React, { Component } from 'react';
import { connect } from 'react-redux';
import { getFriends } from '../../../../../actions/friends';
import { scrfToken, makeUriForRequest } from '../../../../../functions.js';

class Friends extends Component {

  constructor(props) {
    super(props);
    this.props.getFriends();
    this.subscribeOnChangesInFreindList();
  }

  subscribeOnChangesInFreindList() {
    fetch( makeUriForRequest('/get-user-id'), {
      method: 'get'
    }).then(response => {
      response.json().then(httpData => {
        let socket = io(':3001'),
            userId = httpData.userId,
            room   = 'friends-by-user-id:' + userId;

        socket.on(room, (socketData) => {
          this.props.getFriends();
        });
      });
    });
  }

  componentDidUpdate() {
    
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
                onClick={this.openDialog.bind(this)} >
              {item.username}
              <div className="right-contacts-li-element">
                {this.renderOnlineStatus(item.online)}
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
    },
  })
)(Friends);