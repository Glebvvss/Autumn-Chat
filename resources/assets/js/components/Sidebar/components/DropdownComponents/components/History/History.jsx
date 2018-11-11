import React, { Component } from 'react';
import { connect } from 'react-redux';
import ReactScrollbar from 'react-scrollbar-js';
import $ from "jquery";

import { makeUriForRequest } from '../../../../../../functions';

import { getHistoryMoreOldLoadList, 
         getLatestHistoryList } from '../../../../../../actions/history';

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
  }

  componentDidMount() {
    this.changeScrollbarStateByResizeWindow();
    this.props.getLatestHistoryList();
    this.subscribeOnChangesInHistory();
  }

  subscribeOnChangesInHistory() {
    fetch( makeUriForRequest('/get-user-id'), {
      method: 'get'
    })
    .then(response => {
      response.json().then(httpData => {
        let socket = io(':3001'),
            userId = httpData.userId,
            room   = 'get-history-post-of:' + userId;

        socket.on(room, newHistoryPost => {
          this.props.addNewHistoryPost([newHistoryPost]);
        });
      });
    });
  }

  changeScrollbarStateByResizeWindow() {
    window.addEventListener('resize', (event) => {
      this.setState({
        ...this.state,
        scrollbar: {
          width: 240,
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

  getHistoryMoreOldLoadList() {
    let loadNumber = this.props.countLoads + 1;
    this.props.getHistoryMoreOldLoadList(loadNumber, this.props.startPointPostId);
  }

  renderIfFullHistoryNotLoaded() {
    if ( this.props.fullHistoryLoaded !== true ) {
      return (
        <button className="more-history-btn" 
                onClick={this.getHistoryMoreOldLoadList.bind(this)}>

          more
        </button>
      );
    }
  }

  render() {
    return (
      <div className="history-block" style={this.state.visibleComponent}>
        <BlockTitle />
        <ReactScrollbar ref="scrollbar" style={this.state.scrollbar}>
          <ul>
            {
              this.props.history.map((item, index) => (
                <HistoryPost postDetails={item} />
              ))
            }
          </ul>
          {this.renderIfFullHistoryNotLoaded()}
          <BottomElement />
        </ReactScrollbar>
      </div>
    );
  }
}

function BlockTitle(props) {
  return (
    <div className="title-of-history">
      <h1>History</h1>
    </div>
  );
}

function HistoryPost(props) {
  return (
    <li>
      <p>{props.postDetails.text}</p>
      <p className="date">{props.postDetails.created_at}</p>
    </li>
  );
}

function BottomElement(props) {
  return (
    <div style={{ width: '100%', height: '20px' }}></div> 
  );
}

export default connect(
  state => ({
    visible:           state.sidebarDropdownElements.historyVisible,
    history:           state.history.loadedHistoryPosts,
    countLoads:        state.history.countLoads,
    startPointPostId:  state.history.startPointPostId,
    fullHistoryLoaded: state.history.fullHistoryLoaded
  }),
  dispatch => ({
    getHistoryMoreOldLoadList: (loadNumber, startPointPostId) => {
      dispatch( getHistoryMoreOldLoadList(loadNumber, startPointPostId) );
    },
    getLatestHistoryList: () => {
      dispatch( getLatestHistoryList() );
    },
    addNewHistoryPost: newHistoryPost => {
      dispatch({ type: 'ADD_NEW_HISTORY_POST', payload: newHistoryPost });
    }
  })
)(History);