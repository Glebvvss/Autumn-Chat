import React, { Component } from 'react';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import AnimateHeight from 'react-animate-height';

class Communications extends Component {

	constructor(props) {
		super(props);
		this.state = {
			communicationListVisible: true,
			arrowCssClass: 'arrow-down',
			heightList: 'auto'
		}
	}

	hideOrShowCommunicationList() {
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

	openSelectedChat() {
		
	}

	render() {
		return (
			<div className="communications">
				<div className="title">
					<h3>{this.props.title}</h3>
					<span className={this.state.arrowCssClass} 
								onClick={this.hideOrShowCommunicationList.bind(this)} >
								
						<FontAwesomeIcon icon="arrow-circle-up" />
					</span>
				</div>
				<AnimateHeight 
					duration={ 300 }
  				height={ this.state.heightList }>

					<div className="list">
						<ul>
							{
								this.props.items.map((item, index) => (
									<li key={index} 
											className="active-connect" 
											id-item={item.id} 
											type={item.type}
											onClick={this.openSelectedChat.bind(this)}>

											{item.name}
									</li>
								))
							}
						</ul>						
					</div>
				</AnimateHeight>
			</div>
		);
	}

}

export default Communications;