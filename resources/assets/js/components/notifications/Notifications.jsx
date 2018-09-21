import React, { Component } from 'react';
import { connect } from 'react-redux';

class Notifications extends Component {

  constructor(props) {
    super(props);
    this.state = {
      notifocationMessage: '',
      notificationVisible: {
        display: 'none'
      }
    };
  }

  showNotification(props) {
    this.setState({
      ...this.state,
      notifocationMessage: props.notification.message,
      notificationVisible: {
        display: 'block'
      }
    });
  }

  hideNotification() {
    this.setState({
      ...this.state,
      notificationVisible: {
        display: 'none'
      }
    });
  }

  componentWillReceiveProps(props) {    
    this.showNotification(props);
    setTimeout(() => {
      this.hideNotification();
    }, 4000);
  }

  render() {
    return (
      <div className="notification" style={this.state.notificationVisible}>
        { this.state.notifocationMessage }
      </div>
    );
  }

}

export default connect(
  state => ({
    notification: state.notification
  })
)(Notifications);