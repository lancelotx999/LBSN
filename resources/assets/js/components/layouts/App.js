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
import Content from './Content'

export default class App extends Component {
	render() {
		return (
			<Router>
				<div>
					<Header />
			        <Content />
                </div>
			</Router>
		)
	}
}

if (document.getElementById('routing')) {
	ReactDOM.render(<App />, document.getElementById('routing'))
}
