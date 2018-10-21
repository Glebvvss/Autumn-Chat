let defaultState = {
  message: ''
};

export function notification(state = defaultState, action) {

  if ( action.type === 'OUTPUT_NOTIFICATION' ) {
    return {
      message: action.payload
    };
  }
  
  return state;
}