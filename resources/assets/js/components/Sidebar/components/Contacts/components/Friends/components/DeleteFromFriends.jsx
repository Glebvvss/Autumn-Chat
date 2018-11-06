import React, { Component } from 'react';
import { connect } from 'react-redux';

class DeleteFromFriends extends Component {
  constructor(props) {
    super(props);
  }

  click(event) {
    alert('test');
  }

  render() {
    return (
      <div className="delete-from-friends"
           data-friendID={this.props.friendId}
           onClick={this.click.bind(this)}>

        delete
      </div>
    );
  }
}

export default connect(
  state => ({
    
  }),
  dispatch => ({
    
  })
)(DeleteFromFriends);