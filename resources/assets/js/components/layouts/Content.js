import React, { Component } from 'react'
import ReactDOM from 'react-dom'
import { Switch, Route } from 'react-router-dom'

// React Components
import Main from '../Main'
import FormTest from '../Form'
import MapTest from '../Map'
import RegisterLocation from '../registerLocation'
import EditLocation from '../editLocation'
import CreateContract from '../createContract'
import EditContract from '../editLocation'

const Content = () => {
	return ReactDOM.createPortal(
		<Children />,
		document.getElementById('content')
	)
}

export default Content

const Children = () => {
	return (
		<Switch>

    		<Route exact path="/" component={ Main } />
    		<Route path="/form" component={ FormTest } />
    		<Route path="/map" component={ MapTest } />
			<Route path="/registerLocation" component={ RegisterLocation } />
			<Route path="/:id/editLocation" component={EditLocation} exact={true} />
			<Route path="/createContract" component={ CreateContract } />
			<Route path="/:id/editContract" component={EditContract} exact={true} />

    	</Switch>
	)
}
