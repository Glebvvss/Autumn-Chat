import React, { Component } from 'react';
import { connect } from 'react-redux';
import SidebarHead from './components/sidebar-head/SidebarHead';
import SearchFriends from './components/SearchFriends';
import Contacts from './components/contacts/Contacts';
import Friends from './components/contacts/components/Friends';
import ReactScrollbar from 'react-scrollbar-js';
import { getFriends } from '../../actions/friends';
import DropdownComponents from './components/dropdown-components/DropdownComponents';

const scrollbar = {
  width: 260,
  height: '100%',
};
//visible: state.sidebarDropdownElements.friendshipRequestsVisible
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