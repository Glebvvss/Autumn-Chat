import React, { Component } from 'react';
import { connect } from 'react-redux';
import ReactScrollbar from 'react-scrollbar-js';
import { makeUriForRequest } from '../../../../../../../functions';
import { getRecivedFriendshipRequests, 
         comfirmFriendRequest,
         cancelRecivedFriendRequest,
         getCountNewFriendshipRequests,
         getCountNewRecivedFriendshipRequests } from '../../../../../../../actions/friends';

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
          this.props.getCountNewRecivedFriendshipRequests();
        });
      });
    });
  }

  confirmRequest(event) {
    let senderId = event.target.attributes['data-userID']['value'];
    this.props.comfirmRequest(senderId);
  }

  cancelRequest(event) {
    let senderId = event.target.attributes['data-userID']['value'];
    this.props.cancelRecivedRequest(senderId);
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
                          data-userID={item.sender_id} 
                          className="response-action"> confirm </span>|

                    <span onClick={this.cancelRequest.bind(this)} 
                          data-userID={item.sender_id} 
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
    recivedRequests: state.friendshipRequests.recived
  }),
  dispatch => ({
    getRecivedFriendshipRequests: () => {
      dispatch(getRecivedFriendshipRequests());

    },
    comfirmRequest: senderId => {
      dispatch(comfirmFriendRequest(senderId));
    },
    cancelRecivedRequest: senderId => {
      dispatch(cancelRecivedFriendRequest(senderId));
    },
    getCountNewRecivedFriendshipRequests: () => {
      dispatch(getCountNewRecivedFriendshipRequests());
    },
  }),
)(RecivedRequests);