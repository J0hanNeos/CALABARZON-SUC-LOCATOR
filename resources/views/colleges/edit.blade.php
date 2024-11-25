@extends('layouts.app')

@section('content')

    <div class="container">

        <div class="row">
            <h1>Edit Existing SUC</h1>
            <form action = "{{ route('colleges.update',[
            'college' => $sucs -> id
            ]) }}" method ="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!--Avatar-->
                <div class="md-3">
                    <div style="margin:10px;">
                        <img
                                src="{{ asset("storage/images/{$sucs['avatar_url']}") }}"
                                alt="{{ $sucs['avatar.url'] }}"
                                style="width:150px; height:150px; border-radius:50%">
                    </div>

                    <label for="avatar" class="form-label">Avatar</label>
                    <input type="file" name="avatar" id="avatar">
                    @error('avatar')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!--SUC NAME-->
                <div class="mb-3">
                    <label for="name" class="form-label">SUC Name:</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $sucs ->name }}" required>

                    @error('name')
                          <div class="alert alert-danger">{{ $message }}</div>
                      @enderror
                  </div>

                  <!--Address-->
                  <div class="mb-3">
                      <label for="address" class="form-label">Address</label>
                      <input type="text" class="form-control" id="address" name = "address" value="{{ $sucs ->address }}" required>

                      @error('address')
                          <div class="alert alert-danger">{{ $message }}</div>
                      @enderror
                  </div>

                  <!--Contact-->
                  <div class="mb-3">
                    <label for="contact" class="form-label">Contact</label>
                    <input type="text" class="form-control" id="contact" name = "contact_number" value="{{ $sucs ->contact_number}}">

                    @error('contact_number')
                          <div class="alert alert-danger">{{ $message }}</div>
                      @enderror
                  </div>

                  <!--Latitude-->
                  <div class="mb-3">
                      <label for="latitude" class="form-label">Latitude</label>
                      <input type="number" class="form-control" id="latitude" name = "latitude"  step="any" value="{{ $sucs ->latitude}}" required>

                      @error('latitude')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                  </div>

                  <!--Longitude-->
                  <div class="mb-3">
                      <label for="longitude" class="form-label">Longitude</label>
                      <input type="number" class="form-control" id="longitude" name = "longitude"  step="any" value="{{ $sucs ->longitude}}" required>

                      @error('longitude')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                  </div>

                  <!--Website-->
                  <div class="mb-3">
                      <label for="website" class="form-label">Website</label>
                      <input type="text" class="form-control" id="website" name = "website" value="{{ $sucs ->website}}">

                      @error('website')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                  </div>


                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{ route('colleges.index') }}" class="btn btn-success">Back</a>
              </form>
        </div>
    </div>

@endsection



