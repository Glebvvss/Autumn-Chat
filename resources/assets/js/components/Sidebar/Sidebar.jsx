import React, { Component } from 'react';
import ReactScrollbar from 'react-scrollbar-js';

import { connect } from 'react-redux';
import { getFriends } from '../../actions/friends';

import Contacts from './components/Contacts/Contacts.jsx';
import SearchFriends from './components/SearchFriends.jsx';
import Groups from './components/Contacts/components/Groups.jsx';
import Friends from './components/Contacts/components/Friends.jsx';
import SidebarHead from './components/SidebarHead.jsx';
import DropdownComponents from './components/DropdownComponents/DropdownComponents.jsx';

const scrollbar = {
  width: 260,
  height: '100%',
};

class Sidebar extends Component {

	constructor(props) {
		super(props);		
	}

	render() {
		return (
			<div className="sidebar">
				<DropdownComponents />

				<div className="sidebar-main">
					<SidebarHead />
					<SearchFriends />
					<ReactScrollbar style={scrollbar}>
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