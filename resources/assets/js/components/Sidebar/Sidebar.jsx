import React, { Component } from 'react';
import ReactScrollbar from 'react-scrollbar-js';

import { connect } from 'react-redux';
import { getFriends } from '../../actions/friends';

import SidebarHead from './components/SidebarHead.jsx';
import Contacts from './components/Contacts/Contacts.jsx';
import SearchFriends from './components/SearchFriends.jsx';
import Groups from './components/Contacts/components/Groups/Groups.jsx';
import Friends from './components/Contacts/components/Friends/Friends.jsx';
import DropdownComponents from './components/DropdownComponents/DropdownComponents.jsx';

class Sidebar extends Component {

	constructor(props) {
		super(props);

		this.state = {
			scrollbar: {
			  width: 260,
			  height: document.documentElement.clientHeight - 130,
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
				  height: document.documentElement.clientHeight - 130,
				}	
		  });  
		});
	}

	render() {
		return (
			<div className="sidebar">
				<DropdownComponents />

				<div className="sidebar-main">
					<SidebarHead />
					<SearchFriends />
					<ReactScrollbar style={this.state.scrollbar}>
						<div className="scroll-black-content">

							<Contacts title="GROUPS">
								<Groups />
							</Contacts>

							<Contacts title="FRIENDS">
								<Friends />
							</Contacts>

						</div>
					</ReactScrollbar>
				</div>

			</div>
		);
	}

}

export default Sidebar;