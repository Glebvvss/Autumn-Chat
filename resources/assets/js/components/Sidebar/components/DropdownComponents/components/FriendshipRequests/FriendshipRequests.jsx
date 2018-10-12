import React, { Component } from 'react';
import { connect } from 'react-redux';
import ReactScrollbar from 'react-scrollbar-js';

import RecivedRequests from './components/RecivedRequests.jsx';
import SendedRequests from './components/SendedRequests.jsx';

const scrollbar = {
  width: 260,
  height: '100%'
};

class FriendshipRequests extends Component {

  constructor(props) {
    super(props);
    this.state = {
      visibleComponent: {
        left: 0
      }
    };
  }

  componentDidUpdate(prevProps, prevState, snapshot) {
    if ( this.props !== prevProps ) {
      this.checkVisibleStatusFriendShipRequests();
    }
  }

  checkVisibleStatusFriendShipRequests() {
    if ( this.props.visible === true ) {
      this.setState({
        ...this.state,
        visibleComponent: {
          left: '260px'
        }
      });
    } else {
      this.setState({
        ...this.state,
        visibleComponent: {
          left: 0
        }
      });
    }
  }

  render() {
    return (
      <div className="frienship-requests-block" style={this.state.visibleComponent}>
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
    visible: state.sidebarDropdownElements.friendshipRequestsVisible
  }),
  dispatch => ({

  }),
)(FriendshipRequests);