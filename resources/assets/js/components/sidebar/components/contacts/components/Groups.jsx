import React, { Component } from 'react';
import { connect } from 'react-redux';
import { getGroups } from '../../../../../actions/groups';
import { scrfToken, makeUriForRequest } from '../../../../../functions.js';

class Groups extends Component {

  constructor(props) {
    super(props);
    this.props.getGroups();
  }

  socketMethod() {
    fetch( makeUriForRequest('/get-user-id'), {
      method: 'get'
    }).then(response => {
      response.json().then(httpData => {
        let socket = io(':3001'),
            userId = httpData.userId,
            room   = 'friends-by-user-id:' + userId;

        socket.on(room, (socketData) => {
          
        });
      });
    });
  }

  componentDidUpdate(prevProps) {
    if ( this.props !== prevProps ) {
      console.log(this.props.groups);
    }
  }

  highlightActiveItem() {
    
  }

  openDialog() {

  }

  render() {
    return (
      <ul>
        {
          this.props.groups.map((item, index) => (
            <li key={index} 
                onClick={this.openDialog.bind(this)} >
                
              {item.group_name}
            </li>
          ))
        }
      </ul>
    );
  }

}

export default connect(
  state => ({
    groups: state.groups.groups
  }),
  dispatch => ({
    getGroups: () => {
      dispatch(getGroups());
    },
  })
)(Groups);