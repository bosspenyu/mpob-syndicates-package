@if(Session::has('throwable'))
    <div class="row">
        <div class="col-md-12">
            <div class="p-2 alert alert-danger" role="alert">
                {{ Session::get('throwable') }}
            </div>
        </div>
    </div>
@endif
@if(Session::has('success'))
    <div class="row">
        <div class="col-md-12">
            <div class="p-2 alert alert-success" role="alert">
                {{ Session::get('success') }}
            </div>
        </div>
    </div>
@endif

{{--    <div class="alert alert-danger">--}}
{{--        @foreach ($errors->all() as $error)--}}
{{--            {{ $error }}<br>--}}
{{--        @endforeach--}}
{{--    </div>--}}

