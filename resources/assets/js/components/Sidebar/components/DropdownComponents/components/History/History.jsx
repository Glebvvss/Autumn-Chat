import React, { Component } from 'react';
import { connect } from 'react-redux';
import ReactScrollbar from 'react-scrollbar-js';

class History extends Component {
  constructor(props) {
    super(props);

    this.state = {
      visibleComponent: {
        left: 0
      },
      scrollbar: {
        width: '240px',
        height: (document.documentElement.clientHeight / 2) - 20
      }
    };

    this.changeScrollbarStateByResizeWindow();
  }

  changeScrollbarStateByResizeWindow() {
    window.addEventListener('resize', (event) => {
      this.setState({
        ...this.state,
        scrollbar: {
          width: 260,
          height: (document.documentElement.clientHeight / 2) - 20,
        } 
      });
    });
  }

  componentDidUpdate(prevProps, prevState, snapshot) {
    if ( this.props !== prevProps ) {
      this.checkVisibleStatusComponent();
    }
  }

  checkVisibleStatusComponent() {
    if ( this.props.visible === true ) {
      this.setState({
        ...this.state,
        visibleComponent: {
          left: '260px'
        }
      });
    } else {
      this.setState({
        ...this.state,
        visibleComponent: {
          left: 0
        }
      });
    }
  }

  render() {
    return (
      <div className="history-block" style={this.state.visibleComponent}>
        <div className="title-of-history">
          <h1>History</h1>
        </div>
        <ReactScrollbar style={this.state.scrollbar}>
          <ul>
            <li>
              <p>History log text. History log text. History log text. History log text. asdasdasdasdasd</p>
              <p className="date">10.09.2019 | 16:54:12</p>
              <div className="underline-orange"></div>
            </li>                  

            <li>
              <p>History log text. History log text. History log text. History log text. asdasdasdasdasd</p>
              <p className="date">10.09.2019 | 16:54:12</p>
              <div className="underline-orange"></div>
            </li>

            <li>
              <p>History log text. History log text. History log text. History log text. asdasdasdasdasd</p>
              <p className="date">10.09.2019 | 16:54:12</p>
              <div className="underline-orange"></div>
            </li>

            <li>
              <p>History log text. History log text. History log text. History log text. asdasdasdasdasd</p>
              <p className="date">10.09.2019 | 16:54:12</p>
              <div className="underline-orange"></div>
            </li>            

            <li>
              <p>History log text. History log text. History log text. History log text. asdasdasdasdasd</p>
              <p className="date">10.09.2019 | 16:54:12</p>
              <div className="underline-orange"></div>
            </li>
          </ul>
          <div style={{ width: '100%', height: '20px' }}></div>
        </ReactScrollbar>
      </div>
    );
  }
}

export default connect(
  state => ({
    visible: state.sidebarDropdownElements.historyVisible,
  })
)(History);