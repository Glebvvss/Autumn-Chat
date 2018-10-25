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

  resetCheckMarkersIfMembersAdded() {
    
  }

  addOrRomoveCheckMarker(event) {
    const numberOfList = event.target.attributes['data-key']['value'];
    let element = this.props.friends[numberOfList];

    if ( element.hasOwnProperty('selected') && element['selected'] === true ) {
      this.props.friends[numberOfList]['selected'] = false;
    } else {
      this.props.friends[numberOfList]['selected'] = true;
    }

    this.setState({
      ...this.state,
      friends: this.props.friends
    });
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
            this.props.friends.map((item, index) => (
              <li key={index}
                  data-key={index}
                  onClick={this.addFriendToGroup.bind(this)}
                  data-userID={item.id}>

                {item.username}

                {this.renderCheckMarkerOnSelectedElement(item)}
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