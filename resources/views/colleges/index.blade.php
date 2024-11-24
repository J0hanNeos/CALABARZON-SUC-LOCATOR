@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="//cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        #sidebar {
            position: absolute;
            top: 0;
            right: 0;
            width: 300px;
            height: 100%;
            background-color: #f8f9fa;
            box-shadow: -2px 0 5px rgba(0, 0, 0, 0.2);
            overflow-y: auto;
            z-index: 1000;
            display: none; /* Initially hidden */
            padding: 20px;
        }

        #sidebar .close-btn {
            font-size: 18px;
            cursor: pointer;
            margin-bottom: 10px;
            text-align: right;
        }

        #map-container {
            position: relative;
        }

        #map {
            height: 60vh;
            width: calc(100% - 300px);
        }

        #sidebar-search {
            margin-bottom: 15px;
        }
    </style>
@endsection

@section('content')

<div class="container">
    <div class="row mb-3">
        <h1>List of SUCs</h1>

        <div class="col text-end">
            <!-- Button to create a new SUC -->
            <a href="{{ route('sucs.create') }}" class="btn"
            style="width:20rem; background-color:darkslateblue; border-radius:0.5em; color:white; margin-bottom:10px;">
            Add New SUC
            </a>
        </div>


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
                        <th scope="col" >#Id</th>
                        <th scope="col" style="width: 125px;">Logo</th>
                        <th scope="col">Name</th>
                        <th scope="col">Address</th>
                        <th scope="col">Contact #</th>
                        <th scope="col" width="12%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sucs as $suc)
                    <tr>
                        <th scope="row">{{ $suc->id }}</th>
                        <td>
                            <img src="{{ asset("storage/images/{$suc->avatar_url}") }}" alt="Logo"
                                 style="display: block; margin: auto; width:65px; height:65px; border-radius:50%">
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
            <div id="map-container">
                <div id="map"></div>
                <div id="sidebar">
                    <div class="close-btn" id="closeSidebar">&times;</div>
                    <input type="text" id="sidebar-search" class="form-control" placeholder="Search..." />
                    <h5 id="sidebar-name"></h5>
                    <p id="sidebar-address"></p>
                    <p id="sidebar-contact"></p>
                    <a href="#" id="sidebar-website" target="_blank">Visit Website</a>
                </div>
            </div>
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
        const sidebar = document.getElementById('sidebar');
        const closeSidebar = document.getElementById('closeSidebar');
        const sidebarName = document.getElementById('sidebar-name');
        const sidebarAddress = document.getElementById('sidebar-address');
        const sidebarContact = document.getElementById('sidebar-contact');
        const sidebarWebsite = document.getElementById('sidebar-website');

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

        closeSidebar.addEventListener('click', function () {
            sidebar.style.display = 'none';
        });

        // Pass SUCs data to JavaScript
        const colleges = @json($sucs);

        // Initialize Leaflet Map
        const map = L.map('map').setView([14.0556904,121.2528315], 9); // Default center (Manila)
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 15,
            attribution: '© OpenStreetMap'
        }).addTo(map);

        // Add markers for each college
        colleges.forEach(college => {
            if (college.latitude && college.longitude) {
                const marker = L.marker([college.latitude, college.longitude]).addTo(map);
                marker.on('click', () => {
                    sidebar.style.display = 'block';
                    sidebarName.textContent = college.name;
                    sidebarAddress.textContent = `Address: ${college.address}`;
                    sidebarContact.textContent = `Contact: ${college.contact_number}`;
                    sidebarWebsite.href = college.website;
                    sidebarWebsite.textContent = college.website;
                });
            }
        });
    </script>
@endpush
