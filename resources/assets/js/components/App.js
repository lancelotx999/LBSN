import React, { Component } from 'react'
import ReactDOM from 'react-dom'
import {
  BrowserRouter as Router,
  Switch,
  Route,
  Link
} from 'react-router-dom'

// React Components
import Header from './Header'
import Login from './auth/Login'
import Register from './auth/Register'
import Main from './Main'
import FormTest from './Form'
import MapTest from './Map'

export default class App extends Component {
	render() {
		return (
			<Router>
				<div>
					<Header />
					<main className="py-4">
			            <Switch>

		            		<Route exact path="/" component={ Main } />
		            		<Route path="/login" component={ Login } />
		            		<Route path="/register" component={ Register } />

		            		<Route path="/form" component={ FormTest } />
		            		<Route path="/map" component={ MapTest } />

		            	</Switch>
		            </main>
                </div>
			</Router>
		)
	}
}

if (document.getElementById('app')) {
	ReactDOM.render(<App />, document.getElementById('app'))
}
