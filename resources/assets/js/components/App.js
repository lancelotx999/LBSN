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
import Main from './Main'
import Form from './Form'

export default class App extends Component {
	render() {
		return (
			<Router>
				<div>
					<Header />
					<main className="py-4">
			            <Switch>
		            		<Route exact path="/" component={ Main } />
		            		<Route path="/form" component={ Form } />
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
