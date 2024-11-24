@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <!-- Welcome Message and Application Introduction -->
            <div class="text-center mb-4">
                <h3 class="mb-5">Welcome, {{ Auth::user()->name }}!</h3>
                <img src="{{ asset('storage/images/CHED black color monoline.png') }}" alt="SUC Locator Logo" class="img-fluid mt-3 mb-3" style="max-width: 200px;">

                <h2 class="">CALABARZON</h2>
                <h1 class="">State Universities and Colleges Locator</h1>
                <!-- Logo Image -->
                <p class="lead mt-3">This application allows you to explore and manage data on State Universities and Colleges (SUCs) in the region. You can view the list of SUCs either as a detailed table or as a map for easier navigation and location viewing.</p>

                <div class="mt-4">
                    <a href="{{ route('sucs.index') }}" class="btn btn-primary btn-lg">Explore now</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
