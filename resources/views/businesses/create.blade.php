@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h6>
                <a href="{{ url('/') }}">Home</a>
                <i class="fas fa-angle-right"></i>
                @if (url()->previous() == route('business.index'))
                    <a href="{{ route('business.index') }}">My Businesses</a>
                @else
                    <a href="{{ url('/business/listing') }}">Businesses</a>
                @endif
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

                        <div class="form-group">
                            <label for="name">
                                Name:
                            </label>
                            <input
                                id="name" name="name" type="text"
                                class="form-control"
                                placeholder="Enter business name."
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
                                ></textarea>
                        </div>
                        <div class="form-group">
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
                        <div class="form-group">
                            <label for="contact_number">
                                Contact Number:
                            </label>
                            <input
                                id="contact_number" name="contact_number" type="text"
                                class="form-control"
                                placeholder="Enter contact number."
                            />
                        </div>
                        <hr />
                        <div class="form-group">
                            <label for="imageData">Upload Business Image:</label><br />
                            <input type="file" id="imageData" name="imageData" accept="image/png, image/jpeg">
                        </div>
                        <div class="form-group">
                            <label>
                                Business Image Name:
                            </label>
                            <input
                                id="imageName"
                                name="imageName"
                                type="text"
                                class="form-control"
                                placeholder="Enter image name."
                            />
                        </div>
                        <div class="form-group">
                            <label>
                                Business Image Description:
                            </label>
                            <textarea 
                            id="imageDescription" name="imageDescription"
                            class="form-control" rows="3"
                            placeholder="Enter property description."
                            ></textarea>
                        </div>
                        <input
                            id="owner_id" name="owner_id" type="hidden"
                            class="form-control"
                            value="{{ Auth::id() }}"
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
