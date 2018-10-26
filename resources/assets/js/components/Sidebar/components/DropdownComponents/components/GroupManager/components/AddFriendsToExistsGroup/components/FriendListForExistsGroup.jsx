import React, { Component } from 'react';
import { connect } from 'react-redux';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { getFriendsWhoNotInGroup } from '../../../../../../../../../actions/groups';

class FriendListForExistsGroup extends Component {

  constructor(props) {
    super(props);

    this.state = {
      friendsWhoNotInSelectedContact: []
    };
  }

  subscribeOnChangesInMemberListOfGroup() {
    let socket = io(':3001'),
        room   = 'update-members-of-public-group:' + this.props.selectedContactId;

    socket.on(room, (socketData) => {
      this.props.getFriendsWhoNotInGroup(this.props.selectedContactId);
    });
  }

  componentDidMount() {
    this.setState({
      ...this.state,
      friendsWhoNotInSelectedContact: this.props.friendsWhoNotInSelectedContact
    });
  }

  componentDidUpdate(prevProps, prevState, snapshot) {
    if ( this.props !== prevProps ) {
      this.setfriendsWhoNotInSelectedContact();      
    }
  }

  setfriendsWhoNotInSelectedContact() {
    this.setState({
      ...this.state,
      friendsWhoNotInSelectedContact: this.props.friendsWhoNotInSelectedContact
    });
  }

  updateListOfGroupMembers(event) {
    let clickedFriendId = event.target.attributes['data-userID']['value'];
    this.props.updateNewMambersIdToGroupList(clickedFriendId);
  }

  addOrRomoveCheckMarker(event) {
    const numberOfList = event.target.attributes['data-key']['value'];
    let element = this.props.friendsWhoNotInSelectedContact[numberOfList];

    if ( element.hasOwnProperty('selected') && element['selected'] === true ) {
      this.props.friendsWhoNotInSelectedContact[numberOfList]['selected'] = false;
    } else {
      this.props.friendsWhoNotInSelectedContact[numberOfList]['selected'] = true;
    }

    this.setState({
      ...this.state,
      friendsWhoNotInSelectedContact: this.props.friendsWhoNotInSelectedContact
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
    this.subscribeOnChangesInMemberListOfGroup();
    return (
      <div className="list-select-member-to-group">
        <ul>
          {
            this.state.friendsWhoNotInSelectedContact.map((item, index) => (
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
    friends:                        state.friends.friends,
    notification:                   state.notification.message,
    selectedContactId:              state.selectedContact.id,
    newMembersIdToGroupList:        state.selectedContact.newMembersIdToContact,
    friendsWhoNotInSelectedContact: state.selectedContact.friendsWhoNotInSelectedContact,
  }),
  dispatch => ({
    changeFroupMemberList: clickedFriendId => {
      dispatch({ type: 'CHANGE_GROUP_MEMBER_LIST_BEFORE_CREATED', payload: clickedFriendId });
    },
    updateNewMambersIdToGroupList: clickedFriendId => {
      dispatch({ 
        type:    'UPDATE_NEW_MEMBERS_ID_TO_CONTACT_LIST',
        payload: clickedFriendId 
      });
    },
    getFriendsWhoNotInGroup: (contactId) => {
      dispatch( getFriendsWhoNotInGroup(contactId) );
    }
  })
)(FriendListForExistsGroup);