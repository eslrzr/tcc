@extends('adminlte::page')
@section('title', ' Empreiteira Andrades - Administração')
@section('content_header')
    <h1>{{ __('general.change_password') }}</h1>
@stop
@section('content')
    {{-- @include('adminlte::components.tool.datatable') --}}
@stop
@section('plugins.BootstrapSwitch', true)
@include('adminlte::components.tool.onpageload')