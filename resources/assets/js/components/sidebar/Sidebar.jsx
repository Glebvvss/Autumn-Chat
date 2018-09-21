import React, { Component } from 'react';
import SidebarHead from './components/SidebarHead/SidebarHead';
import SearchFriends from './components/SearchFriends';
import Communications from './components/Communications';
import ReactScrollbar from 'react-scrollbar-js';

const scrollbar = {
  width: 260,
  height: '100%',
};

const groups = [
	{ id: '1', name: 'Our Group 1', type: 'group' },
	{ id: '2', name: 'Our Group 2', type: 'group' },
	{ id: '3', name: 'Our Group 3', type: 'group' },
	{ id: '4', name: 'Our Group 4', type: 'group' }
];

const friends = [
	{ id: '1', name: 'Friend 1', type: 'friend' },
	{ id: '2', name: 'Friend 2', type: 'friend' },
	{ id: '3', name: 'Friend 3', type: 'friend' },
	{ id: '4', name: 'Friend 4', type: 'friend' }
];

class Sidebar extends Component {

	constructor(props) {
		super(props);
	}

	render() {
		return (
			<div className="sidebar">				
				<SidebarHead />
				<SearchFriends />
				<ReactScrollbar style={scrollbar}>
					<div className="scroll-black-content">
						<Communications title="GROUPS" items={groups} />
						<Communications title="FRIENDS" items={friends} />
					</div>
				</ReactScrollbar>
			</div>
		);
	}

}

export default Sidebar;