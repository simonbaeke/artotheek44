@extends('layouts.app')

@section('content')

    @isset($user)
        <app-component :user="{{ $user}}" :errors="{{ $errors }}" :old="'{{ json_encode(old()) }}'">


        </app-component>
    @else
        <app-component :errors="{{ $errors }} " :old="'{{ json_encode(old()) }}'"></app-component>
    @endisset

    @if (\Session::has('message'))
        <app-message :message="'{{ \Session::get('message') }}'"></app-message>

    @endif

    <app-auth :old="'{{ json_encode(old()) }}'" :loginerror="{{ $errors->login }}" :registererror="{{ $errors->register }}"/>

@endsection
