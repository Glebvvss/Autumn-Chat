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

	render() {
		if ( this.props.loginState.status === 'user' ) {
			return <ChatMainPage />;
		} else if ( this.props.loginState.status === 'guest' ) {
			return <AuthForms />;
		}	
		return <WaitCheckRole />;
	}
}

function WaitCheckRole() {
	return (
		<div>Loading...</div>
	);
}

function AuthForms(props) {
	return (
		<div className="auth">
			<Auth />
		</div>
	);
}

function ChatMainPage(props) {
	return (
		<div className="main">
      <Notifications />
			<Sidebar />
			<Chat />
		</div>
	);
}

export default connect(
	state => ({
		loginState: state.checkLogin,
		selectedContactId: state.selectedContact.id
	}),
	dispatch => ({
		checkLogin: () => {
			dispatch(checkLogin());
		}
	})
)(Main);