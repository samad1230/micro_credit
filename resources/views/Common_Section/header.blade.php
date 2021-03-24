<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Micro Credit Project." />
    <meta name="author" content="Abdus Samad" />

    <title>{{ "Micro Credit"}}</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('Media/asset/favicon-96x96.png') }}">
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet" />
    <link href="{{asset('assets/css/themes/lite-blue.min.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/css/plugins/perfect-scrollbar.css')}}" rel="stylesheet" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/fontawesome-5.css')}}" />
    <link href="{{asset('assets/css/plugins/metisMenu.min.css')}}" rel="stylesheet" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    @yield('page-css')
</head>
