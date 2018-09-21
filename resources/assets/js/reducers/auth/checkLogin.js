let defaultState = {
	status: '', 
}

export function checkLogin(state = defaultState, action) {

	if ( action.type === 'CHECK_LOGIN' ) {
		return {
			status: action.payload.role
		};
	}

	return state;
}