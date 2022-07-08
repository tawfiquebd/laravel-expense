@if(session()->has('success'))
    <p class="text-success"> {{ session()->get('success') }}</p>
@endif

@if(session()->has('error'))
    <p class="text-danger"> {{ session()->get('error') }}</p>
@endif
