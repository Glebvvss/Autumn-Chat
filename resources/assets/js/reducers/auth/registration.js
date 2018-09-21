let defaultState = {
	errors: 'no errors'
}

export function registration(state = defaultState, action) {
	if ( action.type === 'REGISTRATION_ACTION' ) {
		if ( action.payload.hasOwnProperty('errors') ) {
			return {
				...state,
				errors: action.payload.errors
			};
		} else {
			return defaultState;
		}
	}
	if ( action.type === 'CLEAR_REGISTRATION_FORM_ERRORS' ) {
		return defaultState;
	}

	return state;
}