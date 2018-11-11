@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h6>
                <a href="{{ url('/') }}">Home</a> 
                <i class="fas fa-angle-right"></i>
                <a href="{{ route('business.index') }}">Businesses</a>
            </h6><hr />
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Businesses</h5><hr />
                    <form method="POST" action="{{ route('business.search') }}">
                        @csrf
                        @method('POST')

                        <div class="form-row">
                            <div class="input-group col-md-12 mb-3">
                                <input
                                id="name" name="name" type="text"
                                class="form-control"
                                placeholder="Search.."
                                />
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="submit">
                                        <i class="fas fa-search fa-fw"></i> Search
                                    </button>
                                </div>
                                <div class="accordion" id="accordionExample">
                                    <button class="btn btn-link" type="button" 
                                    data-toggle="collapse" data-target="#collapseOne" 
                                    aria-expanded="true" aria-controls="collapseOne">
                                    <i class="fas fa-filter fa-fw"></i> Filters
                                </button>
                            </div>
                        </div>
                    </div>
                    <div 
                    id="collapseOne" class="collapse" 
                    aria-labelledby="headingOne" data-parent="#accordionExample">
                    <div class="form-row">
                        <div class="col-md-1 offset-md-1 mb-3">
                            <label>Verified:</label>
                            <div class="form-check">
                                <input 
                                id="verified" name="verified" type="checkbox"
                                class="form-check-input" value="true"  
                                />
                                <label class="form-check-label" for="verified">
                                    Yes
                                </label>
                            </div>
                        </div>
                        <div class="col-md-9 mb-3">
                            <label for="services">
                                Services:
                            </label>
                            <div class="input-group mb-3">
                                <input
                                id="services" name="services[]" type="text"
                                class="form-control"
                                placeholder="Enter business service."
                                />
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" id="addMore"><i class="fas fa-plus fa-fw"></i></button>
                                </div>
                            </div>
                            <span id="fieldList"></span>
                        </div>
                    </div>
                </div>

            </form>
        </div>
        <div class="card-body">
            @if ($businesses->isEmpty())
            <br />
            <h1 class="display-4">Hello, it seems empty here!</h1>
            <p class="lead">Why don't you try to add some stuff?</p>
            <hr />
            @endif
            @foreach ($businesses as $business)
            <div class="row">
                <div class="col-sm-3">
                    <img src="https://vignette.wikia.nocookie.net/project-pokemon/images/4/47/Placeholder.png/revision/latest?cb=20170330235552" class="img-fluid" alt="Business logo" />
                </div>
                <div class="col-sm-9">
                    <div class="row">
                        <div class="col-sm-12">
                            <h4>{{ $business->name }}</h4>
                            <p>{{ $business->description }}</p>
                            <hr />
                            <ul class="list-unstyled">
                                <li>
                                    <strong>Contact Number:</strong> 
                                    {{ $business->contact_number }}
                                </li>
                            </ul>
                            <a href="{{ route('business.show', $business->_id) }}">
                                <button class="btn btn-sm btn-success">
                                    <i class="far fa-hand-point-right fa-fw"></i> View
                                </button>
                            </a>
                            @if ($business->owner_id == Auth::id())
                            <a href="{{ route('business.edit', $business->_id) }}">
                                <button class="btn btn-sm btn-success">
                                    <i class="far fa-edit fa-fw"></i> Edit
                                </button>
                            </a>
                            <button type="button" class="btn btn-sm btn-light" data-toggle="modal" 
                            data-target="#deleteModal{{ $business->_id }}">
                            <i class="fas fa-times fa-fw"></i> Delete
                        </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <hr />
        @endforeach
        <a href="{{ route('business.create') }}">Create businesses</a>
    </div>
</div>
</div>
</div>
</div>

<script type="text/javascript">
    $(function() {
    var maxField = 10; //Input fields increment limitation
    var addButton = $('#addMore'); //Add button selector
    var wrapper = $('#fieldList'); //Input field wrapper
    var fieldHTML = '<div class="input-group mb-3"><input id="services" name="services[]" type="text" class="form-control" placeholder="Enter business service." /><div class="input-group-append"><button class="btn btn-outline-secondary remove_button" type="button"><i class="fas fa-times fa-fw"></i></button></div></div>'; // The new input
    var x = 1; //Initial field counter is 1

    //Once add button is clicked
    addButton.click(function(){
        //Check maximum number of input fields
        if(x < maxField){ 
            x++; //Increment field counter
            wrapper.append(fieldHTML); //Add field html
        }
    });

    //Once remove button is clicked
    wrapper.on('click', '.remove_button', function(e){
        e.preventDefault();
        $(this).parent('div').parent('div').remove(); //Remove field html
        x--; //Decrement field counter
    });
});
</script>
@endsection
