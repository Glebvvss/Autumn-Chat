import React, { Component } from 'react';
import { connect } from 'react-redux';
import Sidebar from './sidebar/Sidebar';
import LoginForm from './auth/LoginForm';
import RegistrationForm from './auth/RegistrationForm';
import { checkLogin } from '../actions/auth.js';
import Notifications from './notifications/Notifications';
import Chat from './chat/Chat';

class Main extends Component {
	constructor(props) {
		super(props);
		this.props.checkLogin();
	}

	renderAuthForms() {
		return (
			<div className="auth">
				<LoginForm />
				<RegistrationForm />
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