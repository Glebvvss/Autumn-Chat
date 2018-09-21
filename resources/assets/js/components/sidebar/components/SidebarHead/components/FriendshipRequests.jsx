import React, { Component } from 'react';
import { connect } from 'react-redux';
import ReactScrollbar from 'react-scrollbar-js';

const scrollbar = {
  width: 260,
  height: '100%'
};

class FriendshipRequests extends Component {

  constructor(props) {
    super(props);

    this.state = {
      rootBlockClasses: 'frienship-requests-block unvisible'
    };
  }

  componentDidUpdate(prevProps, prevState, snapshot) {
    if ( this.props !== prevProps ) {
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
  }

  render() {
    return (
      <div className={this.state.rootBlockClasses}>
        <ReactScrollbar style={scrollbar}>
          <ul className="some-frienship-request">
            <li>
              username
              <span className="response-on-friendship-request">
                (
                  <span className="response-action"> confirm </span>|
                  <span className="response-action"> cancel </span>
                )
              </span>
            </li>
          </ul>
        </ReactScrollbar>
      </div>
    );
  }

}

export default connect(
  state => ({}),
  dispatch => ({}),
)(FriendshipRequests);