@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="//cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
@endsection

@section('content')

<div class="container">
    <div class="row">
        <h1>List of SUCs</h1>

        <!-- Button to create a new SUC -->
        <a href="{{ route('sucs.create') }}" class="btn"
           style="width:20rem; background-color:darkslateblue; border-radius:0; border:2px solid black; color:white; margin-bottom:10px;">
            Add New SUC
        </a>

        <!-- Navigation Tabs -->
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#" id="tableViewTab">Table View</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" id="mapViewTab">Map View</a>
            </li>
        </ul>

        <!-- Table View -->
        <div class="container mt-3" id="tableViewContainer">
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
                        <th scope="row">{{ $suc->id }}</th>
                        <td>
                            <img src="{{ asset("storage/images/{$suc->avatar_url}") }}" alt="Logo"
                                 style="display: block; margin: auto; width:50px; height:50px; border-radius:50%">
                        </td>
                        <td>{{ $suc->name }}</td>
                        <td>{{ $suc->address }}</td>
                        <td>{{ $suc->contact_number }}</td>
                        <td>
                            <div style="display: inline-block">
                                <a href="{{ route('sucs.edit', $suc->id) }}" class="btn btn-success">
                                    Edit
                                </a>
                            </div>
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

        <!-- Map View -->
        <div id="mapViewContainer" style="display: none;">
            <div id="map" style="height: 60vh; width:100%;"></div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
    <script src="//cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        $(document).ready(function () {
            $('#listOfHEIs').dataTable();
        });

        const tableViewTab = document.getElementById('tableViewTab');
        const mapViewTab = document.getElementById('mapViewTab');
        const tableViewContainer = document.getElementById('tableViewContainer');
        const mapViewContainer = document.getElementById('mapViewContainer');

        tableViewTab.addEventListener('click', function (e) {
            e.preventDefault();
            tableViewContainer.style.display = 'block';
            mapViewContainer.style.display = 'none';
            tableViewTab.classList.add('active');
            mapViewTab.classList.remove('active');
        });

        mapViewTab.addEventListener('click', function (e) {
            e.preventDefault();
            tableViewContainer.style.display = 'none';
            mapViewContainer.style.display = 'block';
            mapViewTab.classList.add('active');
            tableViewTab.classList.remove('active');

            setTimeout(() => {
                map.invalidateSize();
            }, 200);
        });


        // Initialize Leaflet Map
        const map = L.map('map').setView([14.0299072, 121.6233514], 9); // Centered to Sto. Tomas
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 15,
            attribution: '© OpenStreetMap'
        }).addTo(map);
    </script>
@endpush
