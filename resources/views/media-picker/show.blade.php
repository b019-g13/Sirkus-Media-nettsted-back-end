@extends('partials.master')

@section('content')
    @include('media-picker.show-content')
    <script src="{{ asset('js/media-picker.js') }}"></script>
    <script>setupMediaPicker();</script>
@endsection
