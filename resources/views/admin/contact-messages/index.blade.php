@extends('layouts.main')
@section('title','Contact Messages')
@section('content')
    
    <div class="container-fluid">

        <div class="d-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800"><i class="fa fa-phone" aria-hidden="true"></i> Contact Messages</h1>
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
                @if (session('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
                @endif

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table table-borderless" width="100%">
                            <thead>
                                <tr>
                                    <th class="text-theme">Fullname</th>
                                    <th class="text-theme">Email</th>
                                    <th class="text-theme">Subject</th>
                                    <th class="text-theme">Message</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($messages as $message)
                                <tr>
                                    <td class="text-muted">{{ $message->fullname }}</td>
                                    <td class="text-sm">{{ $message->email }}</td>
                                    <td class="text-sm">{{ $message->subject }}</td>
                                    <td class="text-sm">{{ $message->message }}</td>
                                    <td class="text-sm">
                                        <form action="{{ route('contact-messages.destroy', $message) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </td>
                                    <td class="">{{ $message->created_at->diffForHumans() }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
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