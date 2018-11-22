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
                <a href="{{ route('business.create') }}">Create New Business</a>
            </h6><hr />
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Create Business</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('business.store') }}" enctype="multipart/form-data">
                    	@csrf
                    	@method('POST')
                        <p class="form-group row">
                            <label for="imageData">Choose a profile picture:</label>
                            <input type="file" id="imageData" name="imageData" accept="image/png, image/jpeg">
                        </p>
                        <p>
                            <label>
                                Name:
                                <input
                                    id="imageName"
                                    name="imageName"
                                    type="text"
                                    class="form-control"
                                    placeholder="Enter image name."
                                    required
                                />
                            </label>
                        </p>
                        <p>
                            <label>
                                Description:
                                <input
                                    id="imageDescription"
                                    name="imageDescription"
                                    type="text"
                                    class="form-control"
                                    placeholder="Enter image description."
                                    required
                                />
                            </label>
                        </p>

                        <div class="form-group">
                            <p>
                                <label>
                                    Name:
                                    <input
                                        id="name"
                                        name="name"
                                        type="text"
                                        class="form-control"
                                        placeholder="Enter business name."
                                        required
                                    />
                                </label>
                            </p>
                            <p>
                                <label>
                                    Description:
                                </label>
                                <textarea
                                    class="form-control"
                                    id="description"
                                    name="description"
                                    rows="3"
                                    placeholder="Enter business description."
                                    ></textarea>
                            </p>
                            <p>
                                <label>
                                    Services:
                                    <div class="input-group mb-3">
                                        <input
                                            id="services"
                                            name="services[]"
                                            type="text"
                                            class="form-control"
                                            placeholder="Enter business service."
                                        />
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="button" id="addMore"><i class="fas fa-plus fa-fw"></i></button>
                                        </div>
                                    </div>
                                    <span id="fieldList"></span>
                                </label>
                            </p>
                            <p>
                                <label>
                                    Contact Number:
                                    <input
                                        id="contact_number"
                                        name="contact_number"
                                        type="text"
                                        class="form-control"
                                        placeholder="Enter contact number."
                                    />
                                </label>
                            </p>
                        </div>
                        <input
                            id="owner_id"
                            name="owner_id"
                            type="hidden"
                            class="form-control"
                            value="{{ Auth::id() }}"
                            placeholder="Enter owner ID."
                            required
                        />
                        <button type="submit" class="btn btn-primary">
                            Create Business
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
        console.log(x);
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
        console.log(x);
    });
});
</script>
@endsection
