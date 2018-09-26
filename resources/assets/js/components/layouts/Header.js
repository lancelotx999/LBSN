import React from 'react'
import { Link } from 'react-router-dom'

const Header = () => {
	return (
        <ul className="navbar-nav mr-auto">
    	   <li className="nav-item">
        	   <Link className="nav-link" to="/">Home</Link>
    	   </li>
        	<li className="nav-item">
            	<Link className="nav-link" to="/form">Form</Link>
        	</li>
        	<li className="nav-item">
            	<Link className="nav-link" to="/map">Map</Link>
        	</li>
        </ul>
	)
} 

export default Header
