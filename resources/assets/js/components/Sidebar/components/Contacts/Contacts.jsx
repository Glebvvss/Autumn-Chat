import React, { Component } from 'react';
import { connect } from 'react-redux';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import AnimateHeight from 'react-animate-height';
import { makeUriForRequest } from '../../../../functions.js';
import { getFriends } from '../../../../actions/friends.js';
import { getGroups } from '../../../../actions/groups.js';

class Contacts extends Component {

	constructor(props) {
		super(props);
		this.subscribeOnChangesInUnreadMessageMarkers();

		this.state = {
			communicationListVisible: true,
			arrowCssClass: 'arrow-down',
			heightList: 'auto'
		}
	}

	subscribeOnChangesInUnreadMessageMarkers() {
		fetch( makeUriForRequest('/get-user-id'), {
      method: 'get'
    })
    .then(response => {
      response.json().then(httpData => {
        let socket = io(':3001'),
            userId = httpData.userId,
            room   = 'update-unread-message-merkers-of-user-id:' + userId;

        socket.on(room, (socketData) => {
          this.props.updateFriends();
          this.props.updatePublicGroups();
        });
      });
    });
	}

	hideOrShowContacts() {
		if ( this.state.communicationListVisible === true ) {
			this.setState({
				...this.state,
				communicationListVisible: false,
				arrowCssClass: 'arrow-up',
				heightList: 0
			});
		} else {
			this.setState({
				...this.state,
				communicationListVisible: true,
				arrowCssClass: 'arrow-down',
				heightList: 'auto'
			});
		}
	}

	render() {
		return (
			<div className="contacts">
				<div className="title">
					<h3>{this.props.title}</h3>
					<span className={this.state.arrowCssClass} 
								onClick={this.hideOrShowContacts.bind(this)} >
								
						<FontAwesomeIcon icon="arrow-circle-up" />
					</span>
				</div>
				<AnimateHeight 
					duration={ 300 }
  				height={ this.state.heightList }>

					<div className="list">
						{this.props.children}
					</div>
				</AnimateHeight>
			</div>
		);
	}

}

export default connect(
	state 	 => ({}),
	dispatch => ({
		updateFriends: () => {
			dispatch( getFriends() );
		},
		updatePublicGroups: () => {
			dispatch( getGroups() );
		}
	})
)(Contacts);