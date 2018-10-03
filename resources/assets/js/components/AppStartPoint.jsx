import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import { createStore, applyMiddleware } from 'redux';
import reducer from '../reducers/index.js';
import thunk from 'redux-thunk';
import Main from './Main.jsx';
import { Provider } from 'react-redux';
import { library } from '@fortawesome/fontawesome-svg-core';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faComment, faUserFriends, faArrowCircleUp, faCheckCircle } from '@fortawesome/free-solid-svg-icons';
library.add(faComment, faUserFriends, faArrowCircleUp, faCheckCircle);

import { makeUriForRequest } from '../functions';

const store = createStore(reducer, applyMiddleware(thunk));

export default class AppStartPoint extends Component {
	constructor(props) {
		super(props);
	}

	render() {
		return (
			<Provider store={store}>
				<Main />
			</Provider>
		);
	}
}

if (document.getElementById('main')) {
	ReactDOM.render(<AppStartPoint />, document.getElementById('main'));
}