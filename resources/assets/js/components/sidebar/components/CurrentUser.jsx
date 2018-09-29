import React, { Component } from 'react';
import { connect } from 'react-redux';
import { logoutAction, getUsername } from '../../../actions/auth.js';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';

class CurrentUser extends Component {

	constructor(props) {
		super(props);
		this.props.getUsername();
	}

	initialLogoutAction() {
		this.props.logoutAction();
	}

	render() {
		return (
			<div className="current-user">
				<h1 className="username">{this.props.user.username}</h1>
				<div className="logout" onClick={this.initialLogoutAction.bind(this)}>logout</div>
				<div className="icons">
					<span><FontAwesomeIcon icon="comment" /></span>
					<span><FontAwesomeIcon icon="user-friends" /></span>
				</div>
			</div>
		);
	}

}

export default connect(
	state => ({
		user: state.userInfo
	}),
	dispatch => ({
		logoutAction: () => {
			dispatch(logoutAction());
		},
		getUsername: () => {
			dispatch(getUsername());
		}
	})
)(CurrentUser);