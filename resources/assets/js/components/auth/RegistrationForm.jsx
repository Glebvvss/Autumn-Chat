import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import { connect } from 'react-redux';
import { registrationAction } from '../../actions/auth';

class RegistrationForm extends Component {

	constructor(props) {
		super(props);
		this.clearErrorsIfClickOutsideTheForm();

		this.state = {
			username: '',
			email: '',
			password: '',
			confirmPassword: '',
		};
	}

	handleUsernameChange(event) {
		this.setState({
			...this.state,
			username: event.target.value
		});
	}

	handleEmailChange(event) {
		this.setState({
			...this.state,
			email: event.target.value
		});	
	}

	handlePasswordChange(event) {
		this.setState({
			...this.state,
			password: event.target.value
		});
	}

	handleConfirmPasswordChange(event) {
		this.setState({
			...this.state,
			confirmPassword: event.target.value
		});
	}

	initialRegistrationAction(event) {
		event.preventDefault();
		this.props.registrationAction(
			this.state.username,
			this.state.email,
			this.state.password,
			this.state.confirmPassword,
		);
	}

	printErrorMessageIfItsExist(fieldName) {
		if ( this.props.registration.errors.hasOwnProperty(fieldName) ) {
			return (
				<div className="error-message">{this.props.registration.errors[fieldName][0]}</div>
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
			<div className="registration">
				<div className="title-block-auth"><h4 className="title-auth-form">Registration</h4></div>
				<form onSubmit={this.initialRegistrationAction.bind(this)}>
					<div>
						<input 	className="form-field" 
										type="text" 
										placeholder="username"
										value={this.state.username}
										onChange={this.handleUsernameChange.bind(this)} />

						{this.printErrorMessageIfItsExist('username')}
					</div>
					<div>
						<input 	className="form-field" 
										type="text" 
										placeholder="email"
										value={this.state.email}
										onChange={this.handleEmailChange.bind(this)} />

						{this.printErrorMessageIfItsExist('email')}
					</div>
					<div>
						<input 	className="form-field" 
										type="password" 
										placeholder="password"
										value={this.state.password}
										onChange={this.handlePasswordChange.bind(this)} />

						{this.printErrorMessageIfItsExist('password')}
					</div>

					<div>
						<input 	className="form-field" 
										type="password" 
										placeholder="confirm password"
										value={this.state.confirmPassword}
										onChange={this.handleConfirmPasswordChange.bind(this)} />

						{this.printErrorMessageIfItsExist('confirmPassword')}
					</div>
					<div className="submit-button-block"><button>Create account</button></div>
				</form>
			</div>
		);
	}

}

export default connect(
	state => ({
		registration: state.registration
	}),
	dispatch => ({
		registrationAction: (username, email, password, confirmPassword) => {
			dispatch(registrationAction(username, email, password, confirmPassword));
		},
		clearErrors: () => {
			dispatch({type: 'CLEAR_REGISTRATION_FORM_ERRORS'});
		}
	})
)(RegistrationForm);