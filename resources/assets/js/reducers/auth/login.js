let defaultState = {
	errors: 'no errors'
}

export function login(state = defaultState, action) {
	if ( action.type === 'LOGIN_ACTION' ) {
		if ( action.payload.hasOwnProperty('errors') ) {
			return {
				...state,
				errors: action.payload.errors
			};
		} else {
			return defaultState;
		}
	}
	if ( action.type === 'CLEAR_LOGIN_FORM_ERRORS' ) {
		return defaultState;
	}
	return state;
}