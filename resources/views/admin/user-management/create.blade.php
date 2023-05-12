@extends('layouts.main')
@section('title','Create')
@section('content')

    <div class="container-fluid">
    
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800 ">Create a Barber</h1>
            <a href="{{ route('dashboard') }}" class="btn btn-sm btn-primary shadow-sm rounded-0">
                <i class="fas fa-arrow-left fa-sm text-white-50">
                </i> 
                Back
            </a>
        </div>

    <div class="row justify-content-center ">
        <div class="col-lg-6">
            <div class="card mb-4 shadow-none border-0 rounded-0">
                <div class="card-header py-3 rounded-0 border-0 shadow-none">
                    <h6 class="m-0 font-weight-bold text-light">&nbsp;</h6>
                </div>

                @include('components.alerts.error')
                @include('components.alerts.success')
                @include('components.alerts.warning')
                
                <div class="card-body" id="createUser">
                    <form class="row g-3" method="post" action="{{ route('users.store') }}" enctype="multipart/form-data" autocomplete="off">
                        @csrf
                        <div class="col-12 mt-3">
                            <label for="price" class="form-label">Name<strong class="text-danger"> * </strong> </label>
                            <input type="text" class="form-control rounded-0"  name="name">
                        </div>
                        <div class="col-12 mt-3">
                            <label for="email" class="form-label">Email<strong class="text-danger"> * </strong> </label>
                            <input type="email" class="form-control rounded-0"  name="email">
                        </div>
                        <div class="col-12 mt-3" style="display: none;">
                            <label for="price" class="form-label">Password<strong class="text-danger"> (Send it to user) </strong> </label>
                            <input type="text" class="form-control rounded-0" value="{{ Str::random(8) }}" name="password">
                        </div>
                        <div class="col-12 mt-3">
                            <label for="price" class="form-label">Address<strong class="text-danger"> * </strong> </label>
                            <input type="text" class="form-control rounded-0" name="address">
                        </div>
                        <div class="col-6 mt-3">
                            <label for="price" class="form-label">Contact No.<strong class="text-danger"> * </strong> </label>
                            <input type="text" class="form-control rounded-0" name="contact_no">
                        </div>
                        <div class="col-12 mt-3">
                            <label for="price" class="form-label">Expertise<strong class="text-danger"> * </strong> </label>
                            <input type="text" class="form-control rounded-0" name="expertise">
                        </div>
                        <div class="col-6 mt-3">
                          <label for="price" class="form-label">Role<strong class="text-danger"> </strong> </label>
                          <input type="text" id="role" class="form-control rounded-0" name="role" value="Barber" readonly>
                        </div>
                        <div class="col-6 mt-3">
                            <label for="price" class="form-label"> Avatar <strong class="text-danger"> * </strong> </label>
                            <input type="file" class="form-control rounded-0" name="avatar">
                        </div>
                        <div class="col-12 mt-3">
                            <button type="submit" class="btn btn-primary rounded-0" onclick="this.disabled=true;this.form.submit()">
                                <i class="fas fa-plus fa-sm text-white-50"> </i>
                                    Create
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection