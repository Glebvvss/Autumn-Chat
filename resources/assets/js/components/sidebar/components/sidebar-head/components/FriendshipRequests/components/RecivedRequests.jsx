import React, { Component } from 'react';
import { connect } from 'react-redux';
import ReactScrollbar from 'react-scrollbar-js';
import { makeUriForRequest } from '../../../../../../../functions';
import { getRecivedFriendshipRequests, 
         getFriends,
         comfirmFriendRequest,
         cancelRecivedFriendRequest } from '../../../../../../../actions/friends';


class RecivedRequests extends Component {

  constructor(props) {
    super(props);
    this.props.getRecivedFriendshipRequests();
    this.socketMethod();
  }

  socketMethod() {
    fetch( makeUriForRequest('/get-user-id'), {
      method: 'get'
    }).then(response => {
      response.json().then(httpData => {
        let socket = io(':3001'),
            userId = httpData.userId,
            room   = 'recivied-friend-requests-of:' + userId;

        socket.on(room, (socketData) => {
          this.props.getRecivedFriendshipRequests();
        });
      });
    });
  }

  confirmRequest(event) {
    let senderUsername = event.target.attributes['data-username']['value'];
    this.props.comfirmRequest(senderUsername);
  }

  cancelRequest(event) {
    let senderUsername = event.target.attributes['data-username']['value'];
    this.props.cancelRecivedRequest(senderUsername); 
  }

  render() {
    return (
      <div>      
        <h5 className="caption-friendsip-requests">Received</h5>
        <div className="underline-orange"></div>
        <ul className="some-frienship-request">
          {
            this.props.recivedRequests.map((item, index) => (
              <li key={index}>
                <span>{item.user_sender.username}</span>
                <span className="response-on-friendship-request">
                  (
                    <span onClick={this.confirmRequest.bind(this)}
                          data-username={item.user_sender.username} 
                          className="response-action"> confirm </span>|

                    <span onClick={this.cancelRequest.bind(this)} 
                          data-username={item.user_sender.username} 
                          className="response-action"> cancel </span>
                  )
                </span>
              </li>
            ))
          }
        </ul>
      </div>
    );
  }

}

export default connect(
  state => ({
    recivedRequests: state.friends.recivedRequests
  }),
  dispatch => ({
    getRecivedFriendshipRequests: () => {
      dispatch(getRecivedFriendshipRequests());

    },
    comfirmRequest: (senderUsername) => {
      dispatch(comfirmFriendRequest(senderUsername));
    },
    cancelRecivedRequest: (senderUsername) => {
      dispatch(cancelRecivedFriendRequest(senderUsername));
    },
  }),
)(RecivedRequests);