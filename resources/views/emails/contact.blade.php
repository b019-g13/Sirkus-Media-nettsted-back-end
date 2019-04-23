
@extends('layouts.app')
@section('content')
    {{-- <h2> Du har fått en ny epost via kontakt skjema</h2>
    <div> Avsender: {{$email}}</div>
    <div> {{$bodyMessage}}</div> --}}

    <form action="{{url('contact')}}" method="post">
            @csrf
        <fieldset>
            <legend> Kontakt oss </legend>
            <div>
                <label for="name"> Navn </label>
                <input type="text" name="name" value="" required />
            </div>
            <div>
                <label for="companyName"> Bedriftsnavn </label>
                <input type="text" name="companyName" value="" required />
            </div>
            <div>
                <label for="email"> E-post </label>
                <input type="email" name="email" value="" required />
            </div>
            <div>
                <label for="phone"> Tlf </label>
                <input type="text" name="phone" value="" required />
            </div>
            <div>
                <label for="bodyMessage"> Melding </label>
                <textarea name="bodyMessage" value="" required >
                </textarea> 
            </div>
        </fieldset>
            <div>
                <button type="submit" name="send" > Send email </button>
            </div>
    </form>

@endsection