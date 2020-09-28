@extends('layouts.app')

@section('content')
    login
    <app-main>
        <template slot="navigation">
            <user-navigation/>
        </template>
        <template slot="content">
            <app-login :errors="{{$errors}}"></app-login>
        </template>
    </app-main>
@endsection
