import React, { Component } from 'react';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import AnimateHeight from 'react-animate-height';

class Contacts extends Component {

	constructor(props) {
		super(props);
		this.state = {
			communicationListVisible: true,
			arrowCssClass: 'arrow-down',
			heightList: 'auto'
		}
	}

	hideOrShowContacts() {
		if ( this.state.communicationListVisible === true ) {
			this.setState({
				...this.state,
				communicationListVisible: false,
				arrowCssClass: 'arrow-up',
				heightList: 0
			});
		} else {
			this.setState({
				...this.state,
				communicationListVisible: true,
				arrowCssClass: 'arrow-down',
				heightList: 'auto'
			});
		}
	}

	render() {
		return (
			<div className="contacts">
				<div className="title">
					<h3>{this.props.title}</h3>
					<span className={this.state.arrowCssClass} 
								onClick={this.hideOrShowContacts.bind(this)} >
								
						<FontAwesomeIcon icon="arrow-circle-up" />
					</span>
				</div>
				<AnimateHeight 
					duration={ 300 }
  				height={ this.state.heightList }>

					<div className="list">
						{this.props.children}
					</div>
				</AnimateHeight>
			</div>
		);
	}

}

export default Contacts;