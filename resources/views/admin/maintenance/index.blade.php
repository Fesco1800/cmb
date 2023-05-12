@extends('layouts.main')
@section('title','Maintenance')

@section('styles')
    <style>
        ul.tabs {
            margin: 1.25rem 0px;
            padding: 0;
            display: flex;
            width: 100%;
            gap: 5px;
            border-bottom: 1px #000 solid;
            overflow-x: auto;
            overflow-y: hidden;
        }

        ul.tabs li {
            list-style-type: none;
            padding: 0px 1.25rem;
        }

        ul.tabs li:hover,
        ul.tabs li.active {
            border-bottom: 0.15rem #000 solid;
        }

        ul.tabs li a{
            cursor: pointer;
            color: #000;
            font-size: 26px;
            text-decoration: none;
        }

        ul.tabs li.active a {
            font-weight: 600;
        }
    </style>
@endsection

@section('content')
    
    <div class="container-fluid">

        <div class="d-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800"><i class="fa fa-cogs" aria-hidden="true"></i> Maintenance</h1>
        </div>

            <ul class="tabs">
                <li class="active" for="header">
                    <a>Header</a>
                </li>
                <li for="branch">
                    <a>Branch</a>
                </li>
                <li for="service">
                    <a>Service</a>
                </li>
                <li for="about">
                    <a>About</a>
                </li>
                <li for="contact">
                    <a>Contact</a>
                </li>
                <li for="footer">
                    <a>Footer</a>
                </li>
                <li for="announcement">
                    <a>Announcement</a>
                </li>
            </ul>

            <div class="row">
                <div class="col-md-8">
                    @include('components.alerts.success')
                    @include('components.alerts.warning')

                    <div class="card shadow-none mb-4 border-0 content d-block" id="header">
                        <form action="{{ route('maintenance.store.header') }}" method="POST" enctype="multipart/form-data" >
                            @csrf
                            <input type="text" name="uuid" value="{{ $details->uuid ?? null }}" hidden>
                            <div class="card-header py-3 rounded-0">
                                <h6 class="m-0 font-weight-bold text-light">Header Details</h6>
                            </div>

                            <div class="card-body">
                                <div class="container">
                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Logo</label>
                                                <input type="file" class="form-control" name="logo">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Background image</label>
                                                <input type="file" class="form-control" name="header_bg_image">
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Header Label</label>
                                                <textarea class="form-control" rows="4" name="header_label">{{ $details->header_label ?? null }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer bg-transparent">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>

                    <div class="card shadow-none mb-4 border-0 content d-none" id="branch">

                        <form action="{{ route('maintenance.store.branch') }}" method="POST" enctype="multipart/form-data" >
                            @csrf
                            <input type="text" name="uuid" value="{{ $details->uuid ?? null }}" hidden>
                            <div class="card-header py-3 rounded-0">
                                <h6 class="m-0 font-weight-bold text-light">Branch Details</h6>
                            </div>

                            <div class="card-body">

                                <div class="container">
                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Branch title</label>
                                                <input type="text" class="form-control" name="branch_title" value="{{ $details->branch_title ?? null }}">
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Branch subtitle</label>
                                                <textarea class="form-control" rows="4" name="branch_subtitle">{{ $details->branch_subtitle ?? null }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="card-footer bg-transparent">
                                <button class="btn btn-primary">Update</button>
                            </div>
                        </form>

                    </div>

                    <div class="card shadow-none mb-4 border-0 content d-none" id="service">

                        <form action="{{ route('maintenance.store.service') }}" method="POST" enctype="multipart/form-data" >
                            @csrf
                            <input type="text" name="uuid" value="{{ $details->uuid ?? null }}" hidden>
                            <div class="card-header py-3 rounded-0">
                                <h6 class="m-0 font-weight-bold text-light">Service Details</h6>
                            </div>

                            <div class="card-body">

                                <div class="container">
                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Service title</label>
                                                <input type="text" class="form-control" name="service_title" value="{{ $details->service_title ?? null }}">
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Service subtitle</label>
                                                <textarea class="form-control" rows="4" name="service_subtitle">{{ $details->service_subtitle ?? null }}</textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <hr>

                                    <div class="container">
                                        <div class="card bg-transparent border-0">
                                            <div class="d-flex justify-content-between card-header bg-transparent border-0">
                                                <h5>Landing Page Service List</h5>
                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#pageServiceModal">New</button>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table">
                                                    <thead style="color: #fff;">
                                                        <tr>
                                                            <th>Title</th>
                                                            <th>Description</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($services as $service)
                                                            <tr>
                                                                <td>{{ $service->title }}</td>
                                                                <td>{{ $service->description }}</td>
                                                                <td>
                                                                    <a href="{{ route('maintenance.service.destroy', $service) }}"
                                                                        class="btn btn-outline-danger rounded-0" type="button"
                                                                        onclick="return confirm('Are you sure you want to delete this service?')" 
                                                                    > 
                                                                        <i class="fas fa-trash"> </i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent">
                                <button class="btn btn-primary">Update</button>
                            </div>

                        </form>
                    </div>  

                    <div class="card shadow-none mb-4 border-0 content d-none" id="about">

                        <form action="{{ route('maintenance.store.about') }}" method="POST" enctype="multipart/form-data" >
                            @csrf
                            <input type="text" name="uuid" value="{{ $details->uuid ?? null }}" hidden>
                            <div class="card-header py-3 rounded-0">
                                <h6 class="m-0 font-weight-bold text-light">About Details</h6>
                            </div>

                            <div class="card-body">

                                <div class="container">
                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>About Image</label>
                                                <input type="file" class="form-control" name="about_img">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>About title</label>
                                                <input type="text" class="form-control" name="about_title" value="{{ $details->about_title ?? null }}">
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>About subtitle</label>
                                                <textarea class="form-control" rows="4" name="about_subtitle">{{ $details->about_subtitle ?? null }}</textarea>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>About details</label>
                                                <textarea class="form-control" rows="4" name="about_description">{{ $details->about_description ?? null }}</textarea>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>

                            <div class="card-footer bg-transparent">
                                <button class="btn btn-primary">Update</button>
                            </div>
                        </form>

                    </div>

                    <div class="card shadow-none mb-4 border-0 content d-none" id="contact">

                        <form action="{{ route('maintenance.store.contact') }}" method="POST" enctype="multipart/form-data" >
                            @csrf
                            <input type="text" name="uuid" value="{{ $details->uuid ?? null }}" hidden>
                            <div class="card-header py-3 rounded-0">
                                <h6 class="m-0 font-weight-bold text-light">Contact Details</h6>
                            </div>
                            
                            
                            <div class="card-body">

                                <div class="container">
                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Contact address label</label>
                                                <input type="text" class="form-control" name="contact_address_label" value="{{ $details->contact_address_label ?? null }}">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Contact address details</label>
                                                <input type="text" class="form-control" name="contact_address_details" value="{{ $details->contact_address_details ?? null }}">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Contact mobile number</label>
                                                <input type="text" class="form-control" name="contact_mobile_number" value="{{ $details->contact_mobile_number ?? null }}">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Contact availability</label>
                                                <input type="text" class="form-control" name="contact_availability" value="{{ $details->contact_availability ?? null }}">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Contact email</label>
                                                <input type="text" class="form-control" name="contact_email" value="{{ $details->contact_email ?? null }}">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Contact email details</label>
                                                <input type="text" class="form-control" name="contact_email_details" value="{{ $details->contact_email_details ?? null }}">
                                            </div>
                                        </div>

                                    
                                    </div>
                                    
                                </div>

                            </div>

                            <div class="card-footer bg-transparent">
                                <button class="btn btn-primary">Update</button>
                            </div>
                        </form>

                    </div>

                    <div class="card shadow-none mb-4 border-0 content d-none" id="footer">
                        
                        <form action="{{ route('maintenance.store.footer') }}" method="POST" enctype="multipart/form-data" >
                            @csrf
                            <input type="text" name="uuid" value="{{ $details->uuid ?? null }}" hidden>
                            <div class="card-header py-3 rounded-0">
                                <h6 class="m-0 font-weight-bold text-light">Footer Details</h6>
                            </div>

                            <div class="card-body">

                                <div class="container">
                                    <div class="row">

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Footer details</label>
                                                <textarea class="form-control" rows="4" name="footer_description">{{ $details->footer_description ?? null }}</textarea>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Footer twitter url</label>
                                                <input type="text" class="form-control" name="footer_twitter_url" value="{{ $details->footer_twitter_url ?? null }}">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Footer facebook url</label>
                                                <input type="text" class="form-control" name="footer_facebook_url" value="{{ $details->footer_facebook_url ?? null }}">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Footer instagram url</label>
                                                <input type="text" class="form-control" name="footer_instagram_url" value="{{ $details->footer_instagram_url ?? null }}">
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Footer user manual link</label>
                                                <input type="text" class="form-control" name="footer_manual_link" value="{{ $details->footer_manual_link ?? null }}">
                                            </div>
                                            <div class="form-group">
                                                <label>Footer Data Privacy Statement link</label>
                                                <input type="text" class="form-control" name="footer_privacy_link" value="{{ $details->footer_privacy_link ?? null }}">
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                            
                            <div class="card-footer bg-transparent">
                                <button class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>

                    <div class="card shadow-none mb-4 border-0 content d-none" id="announcement">
                        
                        <form action="{{ route('maintenance.store.announcement') }}" method="POST" enctype="multipart/form-data" >
                            @csrf
                            <input type="text" name="uuid" value="{{ $details->uuid ?? null }}" hidden>
                            <div class="card-header py-3 rounded-0">
                                <h6 class="m-0 font-weight-bold text-light">Announcement Details</h6>
                            </div>

                            <div class="card-body">

                                <div class="container">

                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Announcement Image</label>
                                                <input type="file" class="form-control" name="announcement_img">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Announcement Title</label>
                                                <input type="text" class="form-control" name="announcement_title" value="{{ $details->announcement_title ?? null }}">
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Announcement Description</label>
                                                <textarea class="form-control" name="announcement_description" rows="4">{{ $details->announcement_description ?? null }}</textarea>
                                            </div>
                                        </div>

                                    </div>


                                </div>

                            </div>
                            
                            <div class="card-footer bg-transparent">
                                <button class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-none mb-4 border-0">
                        <div class="card-header py-3 rounded-0" style="background:#63462d; border-radius: 5px 5px 5px 5px !important;">
                            <h6 class="m-0 font-weight-bold text-light">Update Details</h6>
                        </div>

                        <div class="card-body">
                            <div class="container">
                                <h5>Last updated: <span>{{ $details->updated_at ?? null }}</span></h5>
                                <h5>Updated By: <span>{{ $details->user->name ?? null }}</span></h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

    </div>

    @include('components.modals.landingPageServiceModal')

@endsection

@section('scripts')
    <script>

        const tabs = $('.tabs li').each( function(index) {
            
            $(this).on('click', function(index) {

                let value = $(this)[0].attributes.for.value;
                updateActiveTab(value);
                updateActiveContent(value)
            });
        });

        function updateActiveTab(tab) {
            $('.tabs li').each( function(index) {
            
                $(this).removeClass('active')
            });

            $('.tabs li').each( function(index) {
            
                if (tab == $(this)[0].attributes.for.value) {
                    $(this).addClass('active')
                }
            });
        }

        function updateActiveContent(tab) {

            $('.content').each( function(index) {

                $(this).addClass('d-none')
                $(this).removeClass('d-block')
            });

            $('.content').each( function(index) {

                if (tab == $(this)[0].id) {
                    $(this).addClass('d-block')
                }
            });
        }
    </script>
    <script>
    
var notificationsUrl = '{{ route('notifications.index') }}';

</script>
@endsection





