@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h6>
                <a href="{{ url('/') }}">Home</a> 
                <i class="fas fa-angle-right"></i>
                @if (url()->current() == route('business.index'))
                    <a href="{{ route('business.index') }}">My Businesses</a>
                @else
                    <a href="{{ url('/business/listing') }}">Businesses</a>
                @endif
            </h6><hr />
        </div>
    </div>
    <div class="row justify-content-center">
        @if (url()->current() == route('business.index'))
            <div class="col-md-2">
                <div class="list-group">
                    <a href="{{ route('user.index') }}" 
                    class="list-group-item list-group-item-action">
                        My Profile
                    </a>
                    <a href="{{ route('property.index') }}" 
                    class="list-group-item list-group-item-action">
                        My Properties
                    </a>
                    <a href="{{ route('business.index') }}" 
                    class="list-group-item list-group-item-action active">
                        My Businesses
                    </a>
                    <a href="{{ route('contract.index') }}" 
                    class="list-group-item list-group-item-action">
                        My Contracts
                    </a>
                    <a href="{{ route('invoice.index') }}" 
                    class="list-group-item list-group-item-action">
                        My Invoices
                    </a>
                    <a href="{{ route('transaction.index') }}" 
                    class="list-group-item list-group-item-action">
                        My Transactions
                    </a>
                </div>
                <span class="d-none d-sm-block d-md-none"><hr /></span>
            </div>
            <div class="col-md-10">
        @else
            <div class="col-md-12">
        @endif
            <div class="card">
                <div class="card-header">
                    Businesses&nbsp;&#8212;
                    <a href="{{ route('business.create') }}">
                        <i class="fas fa-plus-circle fa-fw"></i> Create a new business
                    </a>
                    <hr />
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
            <h3 class="display-4">Empty!</h3>
            <p class="lead">No businesses have been added yet.</p>
            <hr />
            @endif
            @foreach ($businesses as $business)
            <div class="row">
                <div class="col-sm-3 my-auto text-center">
                    <img src="{{ $business->images[0]["data"] }}" class="img-fluid rounded" 
                    alt="Business image" style="max-height: 200px" />
                </div>
                <div class="col-sm-9">
                    <div class="row">
                        <div class="col-sm-12">
                            <h4>{{ $business->name }}</h4>
                            <p>{{ $business->description }}</p>
                            <hr />
                            <ul class="list-unstyled">
                                <li>
                                    <strong>Owner:</strong> 
                                    {{ App\User::find($business->owner_id)->name }}
                                </li>
                                <li>
                                    <strong>Contact Number:</strong> 
                                    {{ $business->contact_number }}
                                </li>
                            </ul>
                            <a class="nounderline" 
                            href="{{ route('business.show', $business->_id) }}">
                                <button class="btn btn-sm btn-success">
                                    <i class="fas fa-list fa-fw"></i> View
                                </button>
                            </a>
                            @if ($business->owner_id == Auth::id())
                            <a class="nounderline" 
                            href="{{ route('business.edit', $business->_id) }}">
                                <button class="btn btn-sm btn-success">
                                    <i class="fas fa-edit fa-fw"></i> Edit
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
    </div>
</div>
</div>
</div>
</div>

<!-- Modal -->
@foreach ($businesses as $business)
<div class="modal fade" id="deleteModal{{ $business->_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Confirm Deletion</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <p>Are you sure you want to delete this?</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <form method="POST" class="form-inline" 
            action="{{ route('business.destroy', $business->_id) }}">
            @csrf
            @method('DELETE')

            <button type="submit" class="btn btn-danger">
                Delete Now
            </button>
        </form>
    </div>
</div>
</div>
</div>
@endforeach

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
