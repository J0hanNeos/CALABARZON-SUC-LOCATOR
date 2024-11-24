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
            padding: 20px;
            display: block;
        }

        /**
        #sidebar .close-btn {
            font-size: 18px;
            cursor: pointer;
            margin-bottom: 10px;
            text-align: right;
        }
        **/

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

        .sidebar-logo {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            display: none; /* Initially hidden */
            margin: 10px auto;
        }

        #search-results {
            max-height: 300px; /* Set a maximum height for the results container */
            overflow-y: auto; /* Enable vertical scrolling */
            padding-right: 10px; /* Prevent scrollbar from overlapping content */
            position: absolute;
            z-index: 1001;
            background: #f8f9fa;
        }

    </style>
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
            <div id="map-container">
                <div id="map"></div>
                <div id="sidebar">
                    <p id="placeholder-message" style="font-weight: bold; color: gray;">Enter the College Name</p>
                    <input type="text" id="sidebar-search" class="form-control" placeholder="Search..." />
                    <div id="search-results"></div>
                    <img id="sidebar-logo" class="sidebar-logo" src="" alt="College Logo" >
                    <h5 id="sidebar-name"></h5>
                    <p id="sidebar-address"></p>
                    <p id="sidebar-contact"></p>
                    <a href="#" id="sidebar-website" target="_blank" style="display: none;">Visit Website</a>
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
        //const closeSidebar = document.getElementById('closeSidebar');
        const sidebarName = document.getElementById('sidebar-name');
        const sidebarAddress = document.getElementById('sidebar-address');
        const sidebarContact = document.getElementById('sidebar-contact');
        const sidebarWebsite = document.getElementById('sidebar-website');
        const sidebarSearch = document.getElementById('sidebar-search');

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

        /**
        closeSidebar.addEventListener('click', function () {
            sidebar.style.display = 'none';
        });
        **/

        // pass SUCs data to script
        const colleges = @json($sucs);

        // init map
        const map = L.map('map').setView([14.0556904,121.2528315], 9); // default center
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 17,
            attribution: '© OpenStreetMap'
        }).addTo(map);

        // add markers for each college
        colleges.forEach(college => {
        if (college.latitude && college.longitude) {
            const marker = L.marker([college.latitude, college.longitude])
                .bindPopup(`<b>${college.name}</b>`) // Binds the popup with the college name
                .addTo(map);

            marker.on('mouseover', () => marker.openPopup());
            marker.on('mouseout', () => marker.closePopup());

            marker.on('click', () => {
            // Show the sidebar and populate its fields
            sidebar.style.display = 'block';

            // College name (fallback to 'N/A' for null or undefined)
            sidebarName.textContent = college.name || 'N/A';

            // Address (display it as-is)
            sidebarAddress.textContent = `Address: ${college.address}`;

            // Contact number (hide if null or empty)
            if (college.contact_number && college.contact_number.trim() !== '') {
                sidebarContact.textContent = `Contact: ${college.contact_number}`;
            } else {
                sidebarContact.textContent = ''; // Clear the field if no contact number
            }

            // Website (hide if null or empty)
            if (college.website && college.website.trim() !== '') {
                sidebarWebsite.href = college.website;
                sidebarWebsite.textContent = college.website;
                sidebarWebsite.style.display = 'inline';
            } else {
                sidebarWebsite.style.display = 'none'; // Hide the website link
            }

            // Logo (hide if no avatar URL)
            const logoElement = document.getElementById('sidebar-logo');
            if (college.avatar_url) {
                logoElement.src = `{{ asset("storage/images/") }}/${college.avatar_url}`;
                logoElement.style.display = 'block';
            } else {
                logoElement.src = '';
                logoElement.style.display = 'none'; // Hide the logo if not provided
            }

            // Populate the search bar with the college name
            sidebarSearch.value = college.name || '';
            sidebarSearch.dispatchEvent(new Event('input')); // Trigger the input event to handle search logic

            // Hide the search results and reset the container
            const searchResultsContainer = document.getElementById('search-results');
            searchResultsContainer.innerHTML = ''; // Clear search results
            searchResultsContainer.style.display = 'none'; // Hide the search results div
        });


        }
    });

    // search functionality inside the sidebar
    sidebarSearch.addEventListener('input', function () {
    const query = sidebarSearch.value ? sidebarSearch.value.toLowerCase() : ''; // Handle null or undefined values
    const searchResultsContainer = document.getElementById('search-results');
    const placeholderMessage = document.getElementById('placeholder-message');

    sidebar.style.display = 'block'; // ensures that the sidebar is displayed
    searchResultsContainer.innerHTML = '';

    if (query.trim() === '') {
        // Reset the map view to default
        resetMapView();

        // Show placeholder message and clear sidebar content
        placeholderMessage.style.display = 'block';
        sidebarName.textContent = '';
        sidebarAddress.textContent = '';
        sidebarContact.textContent = '';
        sidebarWebsite.style.display = 'none';
        const logoElement = document.getElementById('sidebar-logo');
        logoElement.src = '';
        logoElement.style.display = 'none';
        return; // Exit function early
    }

    // Hide placeholder message when there's a search query
    placeholderMessage.style.display = 'none';

    const filteredColleges = colleges.filter(college => {
        return college.name && college.name.toLowerCase().includes(query);
    });

    if (filteredColleges.length > 0) {
        filteredColleges.forEach(college => {
            const resultItem = document.createElement('div');
            resultItem.textContent = college.name || 'Unknown'; // Handle missing name
            resultItem.style.cursor = 'pointer';
            resultItem.style.padding = '5px 0';
            resultItem.style.borderBottom = '1px solid #ccc';

            resultItem.addEventListener('click', () => {
                // Populate the sidebar with the clicked college's details
                sidebarSearch.value = college.name || 'Unknown'; // Fallback for missing name
                sidebarSearch.dispatchEvent(new Event('input')); // Trigger input event for real-time search handling

                // Handle missing latitude or longitude
                const latitude = college.latitude || 14.0556904; // Default coordinates
                const longitude = college.longitude || 121.2528315;

                map.setView([latitude, longitude], 16);

                // Populate the sidebar
                sidebar.style.display = 'block';
                sidebarName.textContent = college.name || 'Unknown'; // Fallback for missing name
                sidebarAddress.textContent = `Address: ${college.address}`; // Always display address

                // Contact number (clear if missing)
                sidebarContact.textContent = college.contact_number
                    ? `Contact: ${college.contact_number}`
                    : '';

                // Website (hide if missing)
                if (college.website && college.website.trim() !== '') {
                    sidebarWebsite.href = college.website;
                    sidebarWebsite.textContent = college.website;
                    sidebarWebsite.style.display = 'inline';
                } else {
                    sidebarWebsite.style.display = 'none';
                }

                // Logo (hide if missing)
                const logoElement = document.getElementById('sidebar-logo');
                if (college.avatar_url) {
                    logoElement.src = `{{ asset("storage/images/") }}/${college.avatar_url}`;
                    logoElement.style.display = 'block';
                } else {
                    logoElement.style.display = 'none';
                }

                // Hide the search results when an item is clicked
                searchResultsContainer.innerHTML = ''; // Clear the search results
                searchResultsContainer.style.display = 'none'; // Hide the search results div
            });

            searchResultsContainer.appendChild(resultItem);
        });
        } else {
            // If no matches found
            const noResults = document.createElement('div');
            noResults.textContent = 'No matches found.';
            noResults.style.color = 'gray';
            noResults.style.fontStyle = 'italic';
            searchResultsContainer.appendChild(noResults);
        }

        // Show the search results container
        if (filteredColleges.length > 0) {
            searchResultsContainer.style.display = 'block';
        } else {
            searchResultsContainer.style.display = 'none';
        }
    });


    // reset the map to the default view and zoom level
    function resetMapView() {
        map.setView([14.0556904, 121.2528315], 9);
    }
    </script>
@endpush
