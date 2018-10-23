import React, { Component } from 'react';

import LoginForm from './components/LoginForm.jsx';
import RegistrationForm from './components/RegistrationForm.jsx';

class Auth extends Component {

  constructor(props) {
    super(props);
  }

  render() {
    return (
      <div>
        <LoginForm />
        <RegistrationForm />
      </div>
    );
  }

}

export default Auth;