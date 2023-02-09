<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Terms And Conditions</title>
    <link rel="stylesheet" href="{{ asset('modules/events/event_templates/default/lib.css') }}">
    <link rel="stylesheet" href="{{ asset('modules/events/event_templates/default/template.css') }}">
</head>
<body data-spy="scroll">
{{-- Alert --}}
@if($errors->any())
    <div class="alert alert-danger mb-0">
        <ul class="list-unstyled">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@if (session('success'))
    <div class="alert alert-success mb-0">
        {!! session('success') !!}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger mb-0">
        {!! session('error') !!}
    </div>
@endif
<div class="container py-5">
    <h3 class="mb-5">Terms and Conditions ({{$event->name}})</h3>
    {!! $event->terms_and_conditions !!}
</div>

<script src="{{ asset('modules/events/event_templates/default/lib.js') }}"></script>
<script src="{{ asset('vendor/input-mask//dist/inputmask.min.js') }}"></script>
<script src="{{ asset('vendor/input-mask//dist/jquery.inputmask.min.js') }}"></script>
<script src="{{ asset('vendor/input-mask//dist/inputmask.min.js') }}"></script>
<script src="{{ asset('vendor/input-mask//dist/bindings/inputmask.binding.js') }}"></script>
</body>
</html>