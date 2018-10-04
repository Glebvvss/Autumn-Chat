import React, { Component } from 'react';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import ReactScrollbar from 'react-scrollbar-js';
import { connect } from 'react-redux';
import FriendList from './components/FriendList';

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
      },
      groupMemberList: []
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

  addFriendToGroup(event) {
    this.addOrRomoveCheckMarker(event);
    this.updateListOfGroupMembers(event);
  }

  updateListOfGroupMembers(event) {
    let id = event.target.attributes['data-userID'];
    if ( this.state.groupMemberList.indexOf(id.value) === -1 ) {
      this.state.groupMemberList.push(id.value);
    } else {
      const elementToDelete = this.state.groupMemberList.indexOf(id.value);
      this.state.groupMemberList.splice(elementToDelete, 1);
    }
  }

  addOrRomoveCheckMarker(event) {
    let span = event.target.children[0];
    if ( span.style.opacity === '' ) {
      span.style.opacity = '1';
    } else {
      span.style.opacity = '';
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
              {
                this.props.friends.map((item, index) => (
                  <li key={index} 
                      data-userID={item.id}
                      onClick={this.addFriendToGroup.bind(this)}>

                    {item.username}
                    <span className="added-top-group-friend">
                      <FontAwesomeIcon icon="check-circle" />
                    </span>
                  </li>
                ))
              }
            </ul>
          </div>
        </ReactScrollbar>

      </div>
    );
  }

}

export default connect(
  state => ({
    visible: state.sidebarDropdownElements.groupManagerVisible,
    friends: state.friends.friends
  }),
  dispatch => ({

  })
)(GroupManager);