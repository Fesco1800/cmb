@extends('layouts.main')
@section('title','Membership')
@section('content')
    
    <div class="container-fluid">

        <div class="d-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800"> <img src="..\assets\img\achievement-award-medal-icon.svg" style="width: 30px;"> Membership verification</h1>

            <div>
                <a href="{{ route('dashboard') }}" class="btn btn-sm btn-primary shadow-sm rounded-0">
                    <i class="fas fa-arrow-left fa-sm text-white-50"> </i> 
                    Back
                </a>
            </div>
        </div>

            <div class="card shadow-none mb-4 border-0">
                <div class="card-header py-3 rounded-0">
                    <h6 class="m-0 font-weight-bold text-light">&nbsp;</h6>
                </div>
                
                @include('components.alerts.success')
                @include('components.alerts.warning')

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table table-borderless" width="100%">
                            <thead>
                                <tr>
                                    <th class="text-theme">Name</th>
                                    <th class="text-theme">Email</th>
                                    <th class="text-theme">Card Image</th>
                                    <th class="text-theme text-right">&nbsp;</th>
                                    <th></th>
                                </tr>
                            </thead>

                            @if(count($memberships->items()) <= 0)
                                <tbody>
                                    <tr>
                                        <td colspan="7" class="text-center"> No application found. </td>
                                    </tr>
                                </tbody>
                            @endif

                            @foreach($memberships as $membership)
                            <tbody>
                                <tr>
                                    <td class="text-sm">{{ $membership->getUser->name }}</td>
                                    <td class="text-sm">{{ $membership->getUser->email }}</td>
                                    <td class="text-sm">
                                        <div class="text-sm"> 
                                            <button class="btn btn-outline-primary rounded-0 mr-2"
                                                    onclick="previewImage('{{$membership->membership_img}}')"
                                                >
                                                <i class="fas fa-expand"> </i>
                                            </button>
                                        </div></td>
                                    <td class="text-right">
                                        <div class="btn-group">

                                            <a href="{{ route('profile.validation.approve',$membership) }}" class="btn btn-outline-info rounded-0 mr-2" type="button"
                                            onclick="return confirm('Are you sure you want to approve this application?')" 
                                            >
                                                Approve
                                            </a>
                                            <a href="{{ route('profile.validation.disapprove',$membership) }}"
                                                class="btn btn-outline-danger rounded-0" type="button"
                                                onclick="return confirm('Are you sure you want to disapprove this application?')" 
                                            > 
                                                <i class="fas fa-thumbs-down"> </i>
                                            </a>

                                        </div>
                                    </td>
                                    <td class="">{{ $membership->created_at->diffForHumans() }}</td>
                                </tr>
                            </tbody>
                            @endforeach
                        </table>
                        {{ $memberships->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
        @include('components.modals.previewImage')

@endsection
@section('scripts')
<script>

 function previewImage(url) {
    var previewImageDom = document.querySelector('#previewModal');

    if(!previewImageDom) {

        return false
        
    }

    else {

        $('#image-frame').attr('src','/images/card/'+url)

        $('#previewModal').modal('show');
        
    }
 }

</script>

<script>
    
var notificationsUrl = '{{ route('notifications.index') }}';

</script>
@endsection


