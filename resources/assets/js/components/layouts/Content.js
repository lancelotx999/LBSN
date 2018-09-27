import React, { Component } from 'react'
import ReactDOM from 'react-dom'
import { Switch, Route } from 'react-router-dom'

// React Components
import Main from '../Main'
import FormTest from '../Form'
import MapTest from '../Map'

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

    	</Switch>
	)
}
