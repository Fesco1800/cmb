@extends('layouts.main')
@section('title','Create')
@section('content')

    <div class="container-fluid">
    
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Create</h1>
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
                
                <div class="card-body" id="createBranch">
                    <form class="row g-3" method="post" action="{{ route('branch.store') }}" enctype="multipart/form-data" autocomplete="off">
                        @csrf
                        <div class="col-6 mt-3">
                            <label for="price" class="form-label">Branch Name<strong class="text-danger"> * </strong> </label>
                            <input type="text" class="form-control rounded-0" name="branch_name">
                        </div>
                        <div class="col-6 mt-3">
                            <label for="avatar" class="form-label">Location</label>
                            <input type="text" class="form-control rounded-0" name="branch_location">
                        </div>
                        <div class="col-6 mt-3">
                            <label for="avatar" class="form-label">Contact No.</label>
                            <input type="number" class="form-control rounded-0" name="branch_contact">
                        </div>
                        <div class="col-6 mt-3">
                            <label for="avatar" class="form-label">Branch Image</label>
                            <input type="file" class="form-control rounded-0" name="branch_img">
                        </div>
                        <div class="col-12 mt-3">
                            <label for="price" class="form-label">Details<strong class="text-danger"> * </strong> </label>
                            <textarea type="text" class="form-control rounded-0" name="branch_details" rows="4"> </textarea>
                        </div>
                        <div class="col-12 mt-3">
                            <label for="price" class="form-label">Google map url<strong class="text-danger"> * </strong> </label>
                            <textarea type="text" class="form-control rounded-0" name="google_href" rows="4"> </textarea>
                        </div>
                        <div class="col-6 mt-3">
                            <label for="price" class="form-label">Open day from<strong class="text-danger"> * </strong> </label>
                            <select class="form-control rounded-0" name="branch_open_from">
                                <option value="Mon">Mon</option>
                                <option value="Tue">Tue</option>
                                <option value="Wed">Wed</option>
                                <option value="Thur">Thu</option>
                                <option value="Fri">Fri</option>
                                <option value="Sat">Sat</option>
                                <option value="Sun">Sun</option>
                            </select>
                        </div>
                        <div class="col-6 mt-3">
                            <label for="price" class="form-label">To<strong class="text-danger"> * </strong> </label>
                            <select class="form-control rounded-0" name="branch_open_upto">
                                <option value="Mon">Mon</option>
                                <option value="Tue">Tue</option>
                                <option value="Wed">Wed</option>
                                <option value="Thur">Thur</option>
                                <option value="Fri">Fri</option>
                                <option value="Sat">Sat</option>
                                <option value="Sun">Sun</option>
                            </select>
                        </div>
                        <div class="col-6 mt-3">
                            <label for="price" class="form-label">Time open from<strong class="text-danger"> * </strong> </label>
                            <input type="time" class="form-control rounded-0" name="branch_open">
                        </div>
                        <div class="col-6 mt-3">
                            <label for="price" class="form-label">Upto<strong class="text-danger"> * </strong> </label>
                            <input type="time" class="form-control rounded-0" name="branch_close">
                        </div>
                        <div class="col-12 mt-3">
                            <button type="submit" class="btn btn-primary rounded-0" onclick="this.disabled=true;this.form.submit()">
                                <i class="fas fa-plus fa-sm text-white-50"> </i>
                                    Add Branch
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