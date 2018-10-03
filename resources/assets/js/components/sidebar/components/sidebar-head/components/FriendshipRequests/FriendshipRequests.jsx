import React, { Component } from 'react';
import { connect } from 'react-redux';
import ReactScrollbar from 'react-scrollbar-js';
import { makeUriForRequest } from '../../../../../../functions';
import { getFriendshipRequests, 
         comfirmFriendshipRequest,
         cancelFriendshipRequest } from '../../../../../../actions/friends';

import RecivedRequests from './components/RecivedRequests';
import SendedRequests from './components/SendedRequests';

const scrollbar = {
  width: 260,
  height: '100%'
};

class FriendshipRequests extends Component {

  constructor(props) {
    super(props);
    this.state = {
      rootBlockClasses: 'frienship-requests-block unvisible',
    };
  }

  componentDidUpdate(prevProps, prevState, snapshot) {
    if ( this.props !== prevProps ) {
      this.hideOrShowComponentByChangeProp(prevProps);
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

  render() {
    return (
      <div className={this.state.rootBlockClasses}>
        <ReactScrollbar style={scrollbar}>
          <div>
            <RecivedRequests />
            <SendedRequests />
          </div>
        </ReactScrollbar>
      </div>
    );
  }

}

export default connect(
  state => ({
    friendshipRequests: state.friendshipRequests
  }),
  dispatch => ({

  }),
)(FriendshipRequests);