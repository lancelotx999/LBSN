import React, { Component } from 'react';
import ReactDOM from 'react-dom';

export default class FormTest extends Component {
    constructor(props) {
        super(props);
        this.state = {
            box: '',
            desc: 'Please write an essay about your favorite DOM element.',
            fruits: 'coconut'
        };

        this.handleChange = this.handleChange.bind(this);
        this.handleSubmit = this.handleSubmit.bind(this);
    }

    handleChange(event) {
        this.setState({value: event.target.value});
    }

    handleSubmit(event) {
        alert('A name was submitted: ' + this.state.value);
        event.preventDefault();
    }

    render() {
        return (
        	<div className="container">
                <div className="row justify-content-center">
                	<div className="col-md-8">
                        <div className="card">
                            <div className="card-header">Form Component</div>

                            <div className="card-body">
                        		<form onSubmit={this.handleSubmit}>
                                    <p><label>
                                        Name: 
                                        <input name="box" type="text" value={this.state.value} onChange={this.handleChange} />
                                    </label></p>

                                    <p><label>
                                        Textarea: 
                                        <textarea name="desc" value={this.state.value} onChange={this.handleChange} />
                                    </label></p>
                                    
                                    <p><label>
                                        Select: 
                                        <select name="fruits" value={this.state.value} onChange={this.handleChange}  >
                                            <option value="grapefruit">Grapefruit</option>
                                            <option value="lime">Lime</option>
                                            <option value="coconut">Coconut</option>
                                            <option value="mango">Mango</option>
                                        </select>
                                    </label></p>
                                    
                                    <p><label>
                                        File: 
                                        <input type="file" />
                                    </label></p>

                                    <p><input type="submit" value="Submit" /></p>
                                </form>
                            </div>
                        </div>
                	</div>
                </div>
            </div>
        )
    }
}
