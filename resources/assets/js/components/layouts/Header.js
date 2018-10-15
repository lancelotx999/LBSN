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
			<li className="nav-item">
            	<Link className="nav-link" to="allLocations">Property Listing</Link>
        	</li>
			<li className="nav-item">
                <Link className="nav-link" to="/registerLocation">Register Location</Link>
            </li>
			<li className="nav-item">
                <Link className="nav-link" to="/createContract">Register Contract</Link>
            </li>
        </ul>
	)
}

export default Header
