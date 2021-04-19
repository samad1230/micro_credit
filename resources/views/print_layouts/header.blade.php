<!DOCTYPE html>
<html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ "Micro Credit"}}</title>

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('Media/asset/favicon-96x96.png') }}">
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,700,900" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/print/bootstrap.min.css') }}">
    <script src="{{ asset('assets/print/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/print/jquery.min.js') }}"></script>
    @yield('page-css')
</head>
<body>
