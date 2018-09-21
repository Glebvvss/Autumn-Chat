import { scrfToken, makeUriForRequest } from '../functions.js';

export const loginAction = (username, password) => dispatch => {
	fetch( makeUriForRequest('/login'), {
		method: 'post',
		headers: {
			'X-CSRF-TOKEN': scrfToken(),
			'Content-Type': 'application/x-www-form-urlencoded'
		},
		body: 
			'username=' + username + '&' +
			'password=' + password

	}).then((response) => {
		response.json().then(function(data) {
			dispatch({type: 'LOGIN_ACTION', payload: data});
			dispatch(checkLogin());
	  });
	});
};

export const registrationAction = (username, email, password, confirmPassword) => dispatch => {	
	fetch( makeUriForRequest('/registration'), {
		method: 'post',
		headers: {
			'X-CSRF-TOKEN': scrfToken(),
			'Content-Type': 'application/x-www-form-urlencoded'
		},
		body: 
			'username=' 				+ username 				+ '&' +
			'email=' 						+ email 	 				+ '&' +
			'password='					+ password 				+ '&' +
			'confirmPassword='	+ confirmPassword

	}).then((response) => {
		response.json().then(function(data) {
			dispatch({type: 'REGISTRATION_ACTION', payload: data});
			dispatch(checkLogin());
	  });
	});
};


export const logoutAction = () => dispatch => {
	fetch( makeUriForRequest('/logout'), {
		method: 'get'
	}).then((response) => {
		dispatch(checkLogin());
	});
}

export const checkLogin = () => dispatch => {		
	fetch( makeUriForRequest('/check-role-user'), {
		method: 'get'
	}).then((response) => {
		response.json().then(function(data) {
			dispatch({type: 'CHECK_LOGIN', payload: data});
		});
	});
};

export const getUsername = () => dispatch => {
  fetch( makeUriForRequest('/get-username'), {
    method: 'get'
  }).then(response => {
    response.json().then(data => {
      dispatch({type: 'FETCH_USERNAME', payload: data});
    });
  });
}