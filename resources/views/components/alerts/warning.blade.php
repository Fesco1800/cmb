@if(session()->has('warning'))
    <div class="alert alert-warning rounded-0 mt-2" role="alert">
        {{ session()->get('warning') }}
    </div>
@endif
