@extends('layouts.main')
@section('title','Edit')
@section('content')

    <div class="container-fluid">
    
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Edit {{ $service->service_name }}"</h1>
            <a href="{{ route('branch.index') }}" class="btn btn-sm btn-primary shadow-sm rounded-0">
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
                
                <div class="card-body" id="editBranchService">
                    <form class="row g-3" method="post" action="{{ route('branch.services.update',$service) }}" enctype="multipart/form-data" autocomplete="off">
                        @csrf
                        <div class="col-6 mt-3">
                            <label for="price" class="form-label">Service Image</label>
                            <input type="file" class="form-control rounded-0" name="service_img">
                        </div>
                        <div class="col-6 mt-3">
                            <label for="price" class="form-label">Service Name<strong class="text-danger"> * </strong> </label>
                            <input type="text" class="form-control rounded-0" value="{{ $service->service_name }}" name="service_name">
                        </div>
                        <div class="col-6 mt-3">
                            <label for="price" class="form-label">Minutes<strong class="text-danger"> * </strong> </label>
                            <select class="form-control rounded-0" value="{{ $service->minutes }}" name="minutes">
                                <option value="{{ old('minutes',$service->minutes) }}">{{ old('minutes',$service->minutes) }}</option>
                                <option value="30">30</option>
                                <option value="60">60</option>
                                <option value="90">90</option>
                                <option value="120">120</option>
                            </select>
                        </div>
                        <div class="col-6 mt-3">
                            <label for="avatar" class="form-label">Service Fee</label>
                            <input type="number" class="form-control rounded-0" value="{{ $service->service_price }}" name="service_price">
                        </div>
                        <div class="col-12 mt-3">
                            <label for="avatar" class="form-label">Service Details</label>
                            <textarea type="text" class="form-control rounded-0" name="service_detail">{{ $service->service_detail }}</textarea>
                        </div>
                        <div class="col-12 mt-3">
                            <label for="price" class="form-label">Is main service?<strong class="text-danger"> * </strong> </label>
                            <select class="form-control rounded-0" name="isMainService">
                                <option value="1" {{ $service->isMainService == 1 ? 'selected' : '' }}>Yes</option>
                                <option value="0" {{ $service->isMainService == 0 ? 'selected' : '' }}>No</option>
                            </select>
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

@section('scripts')

<script>
    
var notificationsUrl = '{{ route('notifications.index') }}';

</script>

@endsection