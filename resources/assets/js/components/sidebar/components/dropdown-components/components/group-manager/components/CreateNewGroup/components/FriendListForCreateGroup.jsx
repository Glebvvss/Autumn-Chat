import React, { Component } from 'react';
import { connect } from 'react-redux';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { getFriends } from '../../../../../../../../../actions/friends';

class FriendListForCreateGroup extends Component {

  constructor(props) {
    super(props);
    this.props.getFriends();


  }

  addFriendToGroup(event) {
    this.addOrRomoveCheckMarker(event);
    this.updateListOfGroupMembers(event);
  }

  componentDidUpdate(prevProps, prevState, snapshot) {
    if ( this.props !== prevProps ) {
      this.resetCheckMarkersIfMembersAdded();
    }
  }

  updateListOfGroupMembers(event) {
    let clickedFriendId = event.target.attributes['data-userID']['value'];
    this.props.changeFroupMemberList(clickedFriendId);
  }

  addOrRomoveCheckMarker(event) {
    let span = event.target.children[0];
    if ( span.style.opacity === '' ) {
      span.style.opacity = '1';
    } else {
      span.style.opacity = '';
    }
  }

  resetCheckMarkersIfMembersAdded() {
    //document.querySelectorAll('span.added-top-group-friend');
  }

  render() {
    return (
      <div className="list-select-member-to-group">
        <ul>
          {
            this.props.friends.map((item, index) => (
              <li key={index}
                  onClick={this.addFriendToGroup.bind(this)}
                  data-userID={item.id}>

                {item.username}
                <span className="added-top-group-friend" data-id-marker={item.id}>
                  <FontAwesomeIcon icon="check-circle" />
                </span>
              </li> ))
          }
        </ul>
      </div>
    );
  }

}

export default connect(
  state => ({
    friends: state.friends.friends,
    notification: state.notification.message,
  }),
  dispatch => ({
    getFriends: () => {
      dispatch(getFriends());
    },
    changeFroupMemberList: (clickedFriendId) => {
      dispatch({ type: 'CHANGE_GROUP_MEMBER_LIST_BEFORE_CREATED', payload: clickedFriendId });
    },
  })
)(FriendListForCreateGroup);