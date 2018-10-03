import React, { Component } from 'react';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';        
import ReactScrollbar from 'react-scrollbar-js';
import { connect } from 'react-redux';

const scrollbar = {
  width: 260,
  height: '100%',
};

class GroupManager extends Component {

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
      <div className="group-manager-block" style={this.state.visibleComponent}>
        <input className="new-group-name" 
               placeholder="New Group Name" />

        <button className="create-group">Cheate Group</button>

        <ReactScrollbar style={scrollbar}>
          <div className="list-select-member-to-group">
            <ul>

              <li>
                Username 
                <span className="added-top-group-friend">
                  <FontAwesomeIcon icon="check-circle" />
                </span>
              </li>

              <li>
                Username 
                <span className="added-top-group-friend">
                  <FontAwesomeIcon icon="check-circle" />
                </span>
              </li>

              <li>
                Username 
                <span className="added-top-group-friend">
                  <FontAwesomeIcon icon="check-circle" />
                </span>
              </li>

            </ul>
          </div>
        </ReactScrollbar>

      </div>
    );
  }

}

export default connect(
  state => ({
    visible: state.sidebarDropdownElements.groupManagerVisible
  }),
  dispatch => ({

  })
)(GroupManager);