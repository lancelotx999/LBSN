import React from 'react'
import { Link } from 'react-router-dom'

const Header = () => {
	return (
		<nav className="navbar navbar-expand-md navbar-light navbar-laravel">
            <div className="container">

                <Link className="navbar-brand" to="/">
                    KBI App
                </Link>

                <button className="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span className="navbar-toggler-icon"></span>
                </button>

                <div className="collapse navbar-collapse" id="navbarSupportedContent">

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
		                	<Link className="nav-link" to="/registerLocationTest">Register Location</Link>
		            	</li>
                	</ul>

                	<ul class="navbar-nav ml-auto">
                		<li class="nav-item">
                            <Link class="nav-link" to="/login">Login</Link>
                        </li>
                        <li class="nav-item">
                            <Link class="nav-link" to="/register">Register</Link>
                        </li>
                	</ul>

                </div>
            </div>
        </nav>
	)
}

export default Header
