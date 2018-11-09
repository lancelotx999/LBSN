@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h6>
                <a href="{{ url('/') }}">Home</a> 
                <i class="fas fa-angle-right"></i>
                <a href="{{ route('business.index') }}">Businesses</a>
                <i class="fas fa-angle-right"></i>
                <a href="{{ route('business.edit', $business->_id) }}">Edit {{ $business->name }}</a>
            </h6><hr />
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Edit Business</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('business.update', $business) }}">
                    	@csrf
                    	@method('PATCH')

                        <div class="form-group">
                            <label for="name">
                                Name:
                            </label>
                            <input
                                id="name" name="name" type="text"
                                class="form-control"
                                placeholder="Enter business name."
                                value="{{ $business->name }}"
                                required
                            />
                        </div>
                        <div class="form-group">
                            <label for="description">
                                Description:
                            </label>
                            <textarea 
                                id="description" name="description"
                                class="form-control" rows="3"
                                placeholder="Enter business description."
                                >{{ $business->description }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="services">
                                Services:
                            </label>
                            @foreach ($business->services as $service)
                            <div class="input-group mb-3">
                                <input
                                    id="services" name="services[]" type="text"
                                    class="form-control"
                                    placeholder="Enter business service."
                                    value="{{ $service }}"
                                />
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" id="addMore"><i class="fas fa-plus fa-fw"></i></button>
                                </div>
                            </div>
                            @endforeach
                            <span id="fieldList"></span>
                        </div>
                        <div class="form-group">
                            <label for="contact_number">
                                Contact Number:
                            </label>
                            <input
                                id="contact_number" name="contact_number" type="text"
                                class="form-control"
                                placeholder="Enter contact number."
                                value="{{ $business->contact_number }}"
                            />
                        </div>
                        <input
                            id="owner_id"
                            name="owner_id"
                            type="hidden"
                            class="form-control"
                            value="{{ $business->owner_id }}"
                            placeholder="Enter owner ID."
                            required
                        />
                        <button type="submit" class="btn btn-primary">
                            Edit Business
                        </button>
                    </form>
                    <hr />
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
