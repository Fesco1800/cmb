@if(session()->has('message'))
    <div class="alert alert-success rounded-0 mt-2" role="alert">
        {{ session()->get('message') }}
    </div>
@endif
