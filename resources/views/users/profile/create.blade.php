@extends('layouts.main')
@section('title','Create')
@section('content')

    <div class="container-fluid">
    
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Apply membership</h1>
            <a href="{{ route('dashboard') }}" class="btn btn-sm btn-primary shadow-sm rounded-0">
                <i class="fas fa-arrow-left fa-sm text-white-50">
                </i> 
                Back
            </a>
        </div>
    @if($user->isVerified == 0)
    <div class="row justify-content-center ">
        <div class="col-lg-6">
            <div class="card mb-4 shadow-none border-0 rounded-0">
                <div class="card-header py-3 rounded-0 border-0 shadow-none">
                    <h6 class="m-0 font-weight-bold text-light">&nbsp;</h6>
                </div>

                @include('components.alerts.error')
                @include('components.alerts.success')
                @include('components.alerts.warning')
                
                <div class="card-body">
                    <form class="row g-3" method="post" action="{{ route('profile.store') }}" enctype="multipart/form-data" autocomplete="off">
                        @csrf
                        <div class="col-6 mt-3">
                            <label for="price" class="form-label"> Picture of your membership card <strong class="text-danger"> * </strong> </label>
                            <input type="file" class="form-control rounded-0" name="membership_img">
                        </div>
                        <div class="col-12 mt-3">
                            <button type="submit" class="btn btn-primary rounded-0" onclick="this.disabled=true;this.form.submit()">
                                <i class="fas fa-plus fa-sm text-white-50"> </i>
                                    Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="alert alert-info mt-2 rounded-0" role="alert">
        Already a verified account.
    </div>
    @endif

</div>
@endsection