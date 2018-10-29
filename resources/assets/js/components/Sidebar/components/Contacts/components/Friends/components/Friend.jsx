import React, { Component } from 'react';

class Friends extends Component {

  constructor(props) {
    super(props);
  }

  renderIfHaveUnreadMessagesMarker(item) {
    if ( item.unread_message_exists === true ) {
      return (
        <div className="notice-new">NEW</div>
      );
    }
  }

  render() {
    return (
      <li key={index}
          data-friendID={this.props.friend.id}
          onClick={this.selectDialog.bind(this)}
          className={( this.state.selectedFriendId    ==  this.props.friend.id &&
                       this.props.selectedContactType === 'DIALOG' ) ? 'active-contact' : null} >

        {this.props.friend.username}
        {this.renderIfHaveUnreadMessagesMarker(this.props.friend)}

        <div className="right-contacts-li-element">
          {this.test()}
          {this.renderOnlineStatus(item.online)}
        </div>
      </li>
    );
  }

}

export default Friend;