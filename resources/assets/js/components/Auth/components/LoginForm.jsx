import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import { connect } from 'react-redux';
import { loginAction } from '../../../actions/auth';

class LoginForm extends Component {

	constructor(props) {
		super(props);				
		this.clearErrorsIfClickOutsideTheForm();

		this.state = {
			usernameField: '',
			passwordField: '',
		};
	}

	handleUsernameChange(event) {
		this.setState({
			...this.state,
			usernameField: event.target.value
		});
	}

	handlePasswordChange(event) {
		this.setState({
			...this.state,
			passwordField: event.target.value
		});
	}

	initialLoginAction(event) {
		event.preventDefault();
		this.props.loginAction(this.state.usernameField, this.state.passwordField);
	}

	printErrorMessageIfItsExist(fieldName) {
		if ( this.props.login.errors.hasOwnProperty(fieldName) ) {
			return (
				<div className="error-message">{this.props.login.errors[fieldName][0]}</div>
			);	
		}
	}

	clearErrorsIfClickOutsideTheForm(event) {
		document.addEventListener('click', (event) => {
			const domNode = ReactDOM.findDOMNode(this);
			if ((!domNode || !domNode.contains(event.target))) {
				this.props.clearErrors();
			}
		});
	}

	render() {
		return (
			<div className="login">
				<div className="title-block-auth">
					<h4 className="title-auth-form">Login</h4>
				</div>
				<form onSubmit={this.initialLoginAction.bind(this)}>
					<div>
						<input 	className="form-field" 
										placeholder="username"
										type="text"
										value={this.state.usernameField}
										onChange={this.handleUsernameChange.bind(this)} />

						{this.printErrorMessageIfItsExist('username')}
					</div>
					<div>
						<input 	className="form-field" 
										placeholder="password"
										type="password"
										value={this.state.passwordField}
										onChange={this.handlePasswordChange.bind(this)} />

						{this.printErrorMessageIfItsExist('password')}
					</div>
					<div className="submit-button-block"><button>Login</button></div>
				</form>
			</div>
		);
	}

}

export default connect(
	state => ({
		fullStore: state,
		login: state.login
	}),
	dispatch => ({
		loginAction: (username, password) => {
			dispatch(loginAction(username, password));
		},
		clearErrors: () => {
			dispatch({type: 'CLEAR_LOGIN_FORM_ERRORS'});
		}
	}),
)(LoginForm);