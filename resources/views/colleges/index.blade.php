@extends('layouts.app')

@section ('css')
    <link rel = "stylesheet" href="//cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css">
@endsection

@section('content')

<div class="container">
    <div class="row">
        <h1>SUC Management</h1>

        <!-- Button to create a new SUC -->
        <a href="{{ route('sucs.create') }}" class="btn" style="width:20rem; background-color:darkslateblue; border-radius:0; border:2px solid black; color:white; margin-bottom:10px;">
            Add New SUC
        </a>

        <!-- Table to display SUC details -->
        <table class="table table-striped table-bordered" id="listOfHEIs">
            <thead>
                <tr>
                    <th scope="col" width="10rem">#Id</th>
                    <th scope="col" width="20rem">Logo</th>
                    <th scope="col">Name</th>
                    <th scope="col">Address</th>
                    <th scope="col">Contact #</th>
                    <th scope="col" width="20%">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sucs as $suc)
                <tr>
                    <!-- Display SUC details -->
                    <th scope="row">{{ $suc->id }}</th>
                    <td>
                        <img src="{{ asset("storage/images/{$suc->avatar_url}") }}" alt="Logo"
                             style="display: block; margin: auto; width:50px; height:50px; border-radius:50%">
                    </td>
                    <td>{{ $suc->name }}</td>
                    <td>{{ $suc->address }}</td>
                    <td>{{ $suc->contact_number }}</td>
                    <td>
                        <!-- Edit Button -->
                        <div style="display: inline-block">
                            <a href="{{ route('sucs.edit', $suc->id) }}" class="btn btn-success">
                                Edit
                            </a>
                        </div>

                        <!-- Delete Button -->
                        <div style="display: inline-block">
                            <form action="{{ route('sucs.destroy', $suc->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection

@push ('scripts')
    <script src = "//cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>

    <script>
        $(document).ready(function (){
            $('#listOfHEIs').dataTable();
        });
    </script>
@endpush
