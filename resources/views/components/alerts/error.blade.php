@if ($errors->any())
    <div class="alert alert-danger rounded-0 mt-2">
        <ul class="list-unstyled">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
        </ul>
    </div>
@endif
