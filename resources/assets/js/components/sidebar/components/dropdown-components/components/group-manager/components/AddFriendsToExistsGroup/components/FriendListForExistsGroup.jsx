import React, { Component } from 'react';
import { connect } from 'react-redux';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';

class FriendListForExistsGroup extends Component {

  constructor(props) {
    super(props);
  }

  addFriendToGroup(event) {
    this.addOrRomoveCheckMarker(event);
    this.updateListOfGroupMembers(event);
  }

  componentDidUpdate(prevProps, prevState, snapshot) {
    if ( this.props !== prevProps ) {
      
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

  resetCheckMarkers() {
    let elementList = document.querySelectorAll('span.added-top-group-friend');
    elementList.forEach((element) => {
      element.style.opacity = '';
    });
  }

  render() {
    return (
      <div className="list-select-member-to-group">
        <ul>
          {
            this.props.friendsWhoNotInSelectedGroup.map((item, index) => (
              <li key={index}
                  onClick={this.addFriendToGroup.bind(this)}
                  data-userID={item.id}>

                {item.username}
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
    friends:                      state.friends.friends,
    notification:                 state.notification.message,
    friendsWhoNotInSelectedGroup: state.selectedGroup.friendsWhoNotInSelectedGroup,
  }),
  dispatch => ({
    changeFroupMemberList: (clickedFriendId) => {
      dispatch({ type: 'CHANGE_GROUP_MEMBER_LIST_BEFORE_CREATED', payload: clickedFriendId });
    },
  })
)(FriendListForExistsGroup);