@if (\Session::has('success'))
    <div class="alert alert-success my-3">
        <ul>
            <li>{!! \Session::get('success') !!}</li>
        </ul>
    </div>
@endif