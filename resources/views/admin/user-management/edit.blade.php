@extends('layouts.main')
@section('title','Create')
@section('content')

    <div class="container-fluid">
    
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Edit</h1>
            <a href="{{ route('users.index') }}" class="btn btn-sm btn-primary shadow-sm rounded-0">
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
                    <form class="row g-3" method="post" action="{{ route('users.barberUpdate',$user) }}" enctype="multipart/form-data" autocomplete="off">
                        @csrf
                        <div class="col-12 mt-3">
                            <label for="price" class="form-label">Name<strong class="text-danger"> * </strong> </label>
                            <input type="text" class="form-control rounded-0" value="{{ $user->name }}" name="name">
                        </div>
                        <div class="col-12 mt-3">
                            <label for="email" class="form-label">Email<strong class="text-danger"> * </strong> </label>
                            <input type="email" class="form-control rounded-0" value="{{ $user->email }}" name="email">
                        </div>
                        <div class="col-12 mt-3">
                            <label for="price" class="form-label">Address<strong class="text-danger"> * </strong> </label>
                            <input type="text" class="form-control rounded-0" value="{{ $user->address }}" name="address">
                        </div>
                        <div class="col-6 mt-3">
                            <label for="price" class="form-label">Contact No.<strong class="text-danger"> * </strong> </label>
                            <input type="text" class="form-control rounded-0" value="{{ $user->contact_no }}" name="contact_no">
                        </div>
                        @if($user->role == 'Barber')
                            <div class="col-12 mt-3">
                            <label for="price" class="form-label">Expertise<strong class="text-danger"> * </strong> </label>
                            <input type="text" class="form-control rounded-0" value="{{ $user->expertise }}" name="expertise">
                        </div>
                        @else
                            <input type="hidden" name="expertise" value="NA">
                        @endif

                        @if($user->role != 'Admin')
                            <div class="col-12 mt-3">
                            <label for="price" class="form-label">Status<strong class="text-danger"> * </strong> </label>
                            <select class="form-control rounded-0" name="isActive">
                                <option value="1" {{ $user->isActive == 1 ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ $user->isActive == 0 ? 'selected' : '' }}>Inactive</option>
                            </select>
                            </div>
                        @else
                            <div class="col-12 mt-3" style="display: none;">
                            <label for="price" class="form-label">Status<strong class="text-danger" type="hidden"> * </strong> </label>
                            <select class="form-control rounded-0" name="isActive" type="hidden">
                                <option value="1" {{ $user->isActive == 1 ? 'selected' : '' }} type="hidden">Active</option>
                            </select>
                            </div>
                        @endif
                        
                        <div class="col-6 mt-3">
                            <label for="price" class="form-label"> Avatar <strong class="text-danger"> * </strong> </label>
                            <input type="file" class="form-control rounded-0" value="{{ $user->avatar }}" name="avatar">
                        </div>
                        <div class="col-12 mt-3">
                            <button type="submit" class="btn btn-primary rounded-0" onclick="this.disabled=true;this.form.submit()">
                                <i class="fas fa-plus fa-sm text-white-50"> </i>
                                    Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection