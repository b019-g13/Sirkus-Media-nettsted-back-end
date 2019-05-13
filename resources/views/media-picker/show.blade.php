@extends('partials.master')

@section('content')
    @include('media-picker.show-content')
    <script>
        (function() {
            document.body.style.overflow = 'hidden';
            document.querySelector('main').style.padding = '15em 0';
        })();
    </script>
    <script src="{{ asset('js/media-picker.js') }}"></script>
    <script>
        setTimeout(() => {
            window.pageMediaPicker = new mediaPicker();

            window.addEventListener("media-picker-ready", function() {

                window.pageMediaPicker.functions.show();
                window.pageMediaPicker.elements.submitButton.style.display = 'none';
            });
        }, 500);
    </script>
@endsection
