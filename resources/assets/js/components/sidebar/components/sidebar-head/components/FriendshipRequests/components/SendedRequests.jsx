import React, { Component } from 'react';
import { connect } from 'react-redux';
import ReactScrollbar from 'react-scrollbar-js';

import { makeUriForRequest, 
         socketConnectByUserId } from '../../../../../../../functions';

import { getSendedFriendshipRequests,
         comfirmFriendshipRequest,
         cancelSendedFriendshipRequest } from '../../../../../../../actions/friends';


class SendedRequests extends Component {

  constructor(props) {
    super(props);
    this.props.getSendedFriendshipRequests();
    this.socketMethod();
  }

  socketMethod() {
    fetch( makeUriForRequest('/get-user-id'), {
      method: 'get'
    }).then(response => {
      response.json().then(httpData => {
        let socket = io(':3001'),
            userId = httpData.userId,
            room   = 'sended-friend-requests-of:' + userId;

        socket.on(room, (socketData) => {
          this.props.getSendedFriendshipRequests();
        });
      });
    });
  }

  cancelSendedRequest(event) {
    let recipientUsername = event.target.attributes['data-username']['value'];
    this.props.cancelSendedFriendshipRequest(recipientUsername);
  }

  render() {
    return (
      <div>      
        <h5 className="caption-friendsip-requests">Sended</h5>
        <div className="underline-orange"></div>
        <ul className="some-frienship-request">
          { this.props.sendedRequests.map((item, index) => (
            <li key={index}>
              <span>{item.user_sender.username}</span>
              <span className="response-on-friendship-request">
                (
                  <span onClick={this.cancelSendedRequest.bind(this)} 
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
    sendedRequests: state.friends.sendedRequests
  }),
  dispatch => ({
    getSendedFriendshipRequests: () => {
      dispatch(getSendedFriendshipRequests());
    },
    cancelSendedFriendshipRequest: (recipientUsername) => {
      dispatch(cancelSendedFriendshipRequest(recipientUsername));
    }
  }),
)(SendedRequests);