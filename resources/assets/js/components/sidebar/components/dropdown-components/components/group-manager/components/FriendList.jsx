import React, { Component } from 'react';
import { connect } from 'react-redux';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';

class FriendList extends Component {

  constructor(props) {
    super(props);
  }

  addFriendToGroup(event) {
    this.addOrRomoveCheckMarker(event);
    this.updateListOfGroupMembers(event);
  }

  updateListOfGroupMembers(event) {
    let id = event.target.attributes['data-userID'];
    if ( this.props.groupMemberList.indexOf(id.value) === -1 ) {
      this.props.groupMemberList.push(id.value);
    } else {
      const elementToDelete = this.state.groupMemberList.indexOf(id.value);
      this.props.groupMemberList.splice(elementToDelete, 1);
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
      <div className="list-select-member-to-group">
        <ul>
          {
            this.props.friends.map((item, index) => (
              <li key={index} 
                  data-userID={item.user_friend.id}
                  onClick={this.addFriendToGroup.bind(this)}>

                {item.user_friend.username}
                <span className="added-top-group-friend">
                  <FontAwesomeIcon icon="check-circle" />
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
    friends: state.friends.friends
  }),
  dispatch => ({

  })
)(FriendList);