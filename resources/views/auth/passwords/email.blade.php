@extends('layouts.app')

@section('content')



    <app-component :errors="{{ $errors }}">
        <template>
            <app-navigation></app-navigation>
            <v-container>
                <v-layout>
                    <v-card>
                        <v-card-title class="card-header">{{ __('Reset Password') }}</v-card-title>

                        <v-card-text>
                            @if (session('status'))
                                <v-alert class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </v-alert>
                            @endif

                            <form id="reset" name="reset" method="POST" action="{{ route('password.email') }}">
                                @csrf

                                <v-text-field
                                        type="email"
                                        name="email"
                                        label="Email"
                                        value="{{old('email')}}"

                                />


                            </form>
                        </v-card-text>
                        <v-card-actions>
                            <v-btn form="reset" type="submit">
                                {{ __('Send Password Reset Link') }}
                            </v-btn>
                        </v-card-actions>

                    </v-card>

                </v-layout>
            </v-container>

        </template>
    </app-component>


    @if (\Session::has('message'))
        <app-message :message="'{{ \Session::get('message') }}'"></app-message>

    @endif

    <app-auth :loginerror="{{ $errors->login }}" :registererror="{{ $errors->register }}"/>
@endsection
