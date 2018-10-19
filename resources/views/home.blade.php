@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Laravel Blade</div>

                <div class="card-body">
                    <p>I'm an example blade!</p>
                    <p>Hello Leslie, all of this HTML is written on <strong>resources/assets/js/components/Example.js</strong></p>
                    <p>And the page render is done as one written line on <strong>resources/views/home.blade.php</strong></p>
                    <p>Take a look at both and you should understand how basic React.js works!</p>
                    <p>
                        Oh and everytime you make changes to the JS file,
                        you need to compile the assets to see the changes cause laravel assets ya'know and
                        we'll get the skeleton done today!
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
