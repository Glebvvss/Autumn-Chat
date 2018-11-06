import React, { Component } from 'react';
import { connect } from 'react-redux';
import { deleteFromFriendList } from '../../../../../../../actions/friends.js';

class DeleteFromFriends extends Component {
  constructor(props) {
    super(props);
  }

  deleteFromFriendList(event) {
    let friendId = event.target.attributes['data-friendID']['value'];

    this.props.deleteFromFriendList(friendId);
  }

  render() {
    return (
      <div className="delete-from-friends"
           data-friendID={this.props.friendId}
           onClick={this.deleteFromFriendList.bind(this)}>

        delete
      </div>
    );
  }
}

export default connect(
  state => ({
    
  }),
  dispatch => ({
    deleteFromFriendList: friendId => {
      dispatch( deleteFromFriendList(friendId) );
    }
  })
)(DeleteFromFriends);