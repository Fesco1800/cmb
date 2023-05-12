@extends('layouts.main')
@section('title','Create')
@section('content')

    <div class="container-fluid">
    
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Add Barber to "{{ $branch->branch_name }}"</h1>
            <a href="{{ route('branch.index') }}" class="btn btn-sm btn-primary shadow-sm rounded-0">
                <i class="fas fa-arrow-left fa-sm text-white-50">
                </i> 
                Back
            </a>
        </div>

    <div class="row justify-content-center ">
        <div class="col-lg-4">
            <div class="card mb-4 shadow-none border-0 rounded-0">
                <div class="card-header py-3 rounded-0 border-0 shadow-none">
                    <h6 class="m-0 font-weight-bold text-light">&nbsp;</h6>
                </div>

                @include('components.alerts.error')
                @include('components.alerts.success')
                @include('components.alerts.warning')
                
                <div class="card-body" id="addBarberToBranch">
                    <form class="row g-3" method="post" action="{{ route('branch.barber.store',$branch) }}" enctype="multipart/form-data" autocomplete="off">
                        @csrf
                        <div class="col-12 mt-3">
                            <label for="price" class="form-label">Choose<strong class="text-danger"> * </strong> </label>
                            <select class="form-control rounded-0" name="barber">
                                @foreach($barbers as $barber)
                                    @if(!$barber->hasBranch)
                                    <option value="{{ $barber->id }}"> {{ $barber->name }} </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 mt-3">
                            <button type="submit" class="btn btn-primary rounded-0" onclick="this.disabled=true;this.form.submit()">
                                <i class="fas fa-plus fa-sm text-white-50"> </i>
                                    Add
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8">
        <div class="card rounded-0">
            <div class="card-header py-3 rounded-0 border-0 shadow-none">
                <h6 class="m-0 font-weight-bold text-light">Barbers</h6>
            </div>
                <div class="card-body" id="branchBarberList">
                    <table class="table table-hover table table-borderless" width="100%">
                        <tbody>
                            <thead>
                                <tr>
                                    <th class="text-theme">Barber's Name</th>
                                    <th class="text-theme">&nbsp;</th>
                                </tr>
                            </thead>
                        </tbody>

                        @if(count($barbersList) <= 0)
                            <tbody>
                                <tr>
                                    <td colspan="2" class="text-center"> No barbers found. </td>
                                </tr>
                            </tbody>
                        @endif

                        @foreach($barbersList as $barber)
                        <tbody>
                            <tr>
                                <td class="text-muted"> {{ $barber->getUser->name }} </td>
                                <td class="text-right">
                                    <div class="btn-group">
                                        <a href="{{ route('branch.barber.destroy',$barber) }}"
                                            class="btn btn-outline-danger rounded-0" type="button"
                                            onclick="return confirm('Are you sure you want to remove this barber?')" 
                                        > 
                                            <i class="fas fa-trash"> </i>
                                            Remove
                                        </a>

                                    </div>
                                </td>
                            </tr>
                        </tbody>
                        @endforeach
                    </table>
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