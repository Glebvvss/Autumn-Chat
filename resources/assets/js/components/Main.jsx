import React, { Component } from 'react';

import { connect } from 'react-redux';
import { checkLogin } from '../actions/auth.js';

import Chat from './Chat/Chat.jsx';
import Auth from './Auth/Auth.jsx';
import Sidebar from './Sidebar/Sidebar.jsx';
import Notifications from './Notifications/Notifications.jsx';

class Main extends Component {
	constructor(props) {
		super(props);
		this.props.checkLogin();
	}

	renderAuthForms() {
		return (
			<div className="auth">
				<Auth />
			</div>
		);
	}

	renderChatMainPage() {
		return (
			<div className="main">
        <Notifications />
				<Sidebar />
				<Chat />
			</div>
		);
	}

	renderWaitCheckRole() {
		return (
			<div>Loading...</div>
		);
	}

	render() {		
		if ( this.props.loginState.status === 'user' ) {
			return this.renderChatMainPage();
		} else if ( this.props.loginState.status === 'guest' ) {
			return this.renderAuthForms();
		}	
		return this.renderWaitCheckRole();
	}
}

export default connect(
	state => ({
		loginState: state.checkLogin
	}),
	dispatch => ({
		checkLogin: () => {
			dispatch(checkLogin());
		}
	})
)(Main);