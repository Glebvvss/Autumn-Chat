import React, { Component } from 'react';
import { connect } from 'react-redux';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';

class FriendListForExistsGroup extends Component {

  constructor(props) {
    super(props);

    this.state = {
      friendsWhoNotInSelectedGroup: []
    };
  }

  componentDidMount() {
    this.setState({
      ...this.state,
      friendsWhoNotInSelectedGroup: this.props.friendsWhoNotInSelectedGroup
    });
  }

  componentDidUpdate(prevProps, prevState, snapshot) {
    if ( this.props !== prevProps ) {
      this.setFriendsWhoNotInSelectedGroup();      
    }
  }

  setFriendsWhoNotInSelectedGroup() {
    this.setState({
      ...this.state,
      friendsWhoNotInSelectedGroup: this.props.friendsWhoNotInSelectedGroup
    });
  }

  updateListOfGroupMembers(event) {
    let clickedFriendId = event.target.attributes['data-userID']['value'];
    this.props.updateNewMambersIdToGroupList(clickedFriendId);
  }

  addOrRomoveCheckMarker(event) {
    const numberOfList = event.target.attributes['data-key']['value'];
    let element = this.props.friendsWhoNotInSelectedGroup[numberOfList];

    if ( element.hasOwnProperty('selected') && element['selected'] === true ) {
      this.props.friendsWhoNotInSelectedGroup[numberOfList]['selected'] = false;
    } else {
      this.props.friendsWhoNotInSelectedGroup[numberOfList]['selected'] = true;
    }

    this.setState({
      ...this.state,
      friendsWhoNotInSelectedGroup: this.props.friendsWhoNotInSelectedGroup
    });
  }

  resetCheckMarkers() {
    let elementList = document.querySelectorAll('span.added-top-group-friend');
    elementList.forEach((element) => {
      element.style.opacity = '';
    });
  }

  addSelectedFriendsToGroup(event) {
    this.addOrRomoveCheckMarker(event);
    this.updateListOfGroupMembers(event);
  }

  renderCheckMarkerOnSelectedElement(item) {
    if ( item.hasOwnProperty('selected') && item.selected === true ) {
      return (
        <span className="add-to-group-friend">
          <FontAwesomeIcon icon="check-circle" />
        </span>
      );
    }
  }

  render() {
    return (
      <div className="list-select-member-to-group">
        <ul>
          {
            this.state.friendsWhoNotInSelectedGroup.map((item, index) => (
              <li key={index}
                  data-key={index}
                  onClick={this.addSelectedFriendsToGroup.bind(this)}
                  data-userID={item.id}>

                {item.username}

                {this.renderCheckMarkerOnSelectedElement(item)}
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
    newMembersIdToGroupList:      state.selectedGroup.newMembersIdToGroupList,
    friendsWhoNotInSelectedGroup: state.selectedGroup.friendsWhoNotInSelectedGroup,
  }),
  dispatch => ({
    changeFroupMemberList: (clickedFriendId) => {
      dispatch({ type: 'CHANGE_GROUP_MEMBER_LIST_BEFORE_CREATED', payload: clickedFriendId });
    },
    updateNewMambersIdToGroupList: (clickedFriendId) => {
      dispatch({ 
        type:    'UPDATE_NEW_MEMBERS_ID_TO_GROUP_LIST',
        payload: clickedFriendId 
      });
    }
  })
)(FriendListForExistsGroup);