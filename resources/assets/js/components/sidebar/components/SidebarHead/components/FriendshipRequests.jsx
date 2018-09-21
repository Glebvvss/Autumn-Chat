import React, { Component } from 'react';
import { connect } from 'react-redux';
import ReactScrollbar from 'react-scrollbar-js';
import { getFriendshipRequests, 
         comfirmFriendshipRequest,
         cancelFriendshipRequest } from '../../../../../actions/friends';

const scrollbar = {
  width: 260,
  height: '100%'
};

class FriendshipRequests extends Component {

  constructor(props) {
    super(props);
    this.state = {
      rootBlockClasses: 'frienship-requests-block unvisible',
      friendshipRequests: []
    };
    this.props.getFriendshipRequests();
  }

  componentDidUpdate(prevProps, prevState, snapshot) {
    if ( this.props !== prevProps ) {
      this.hideOrShowComponentByChangeProp(prevProps);
      this.updateFriendshipRequests(prevProps);
    }
  }

  hideOrShowComponentByChangeProp(prevProps) {
    if ( this.props.visible === true ) {
        this.setState({
        ...this.state,
        rootBlockClasses: 'frienship-requests-block visible'
      });
    } else {
      this.setState({
        ...this.state,
        rootBlockClasses: 'frienship-requests-block unvisible'
      });
    }  
  }

  updateFriendshipRequests(prevProps) {
    if ( prevProps.friendshipRequests !== this.props.friendshipRequests ) {
      this.setState({
        ...this.state,
        friendshipRequests: this.props.friendshipRequests
      });
    }
  }

  confirmRequest(event) {
    let senderUsername = event.target.attributes['data-username']['value'];
    this.props.confirmRequest(senderUsername);
  }

  cancelRequest(event) {
    let senderUsername = event.target.attributes['data-username']['value'];
    this.props.cancelRequest(senderUsername); 
  }

  render() {
    return (
      <div className={this.state.rootBlockClasses}>
        <ReactScrollbar style={scrollbar}>
          <ul className="some-frienship-request">
            {
              this.state.friendshipRequests.map((item, index) => (
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
        </ReactScrollbar>
      </div>
    );
  }

}

export default connect(
  state => ({
    friendshipRequests: state.friends.friendshipRequests
  }),
  dispatch => ({
    getFriendshipRequests: () => {
      dispatch(getFriendshipRequests());
    },
    confirmRequest: (senderUsername) => {
      dispatch(comfirmFriendshipRequest(senderUsername));
    },
    cancelRequest: (senderUsername) => {
      dispatch(cancelFriendshipRequest(senderUsername));
    },
  }),
)(FriendshipRequests);