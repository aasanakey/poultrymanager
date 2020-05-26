@extends('errors.minimal')

@section('title', __('Not Found'))
@section('code')
     <img class="mb-4 img-error" src="{{asset('/assets/img/error-404-monochrome.svg')}}" />
@endsection
@section('message', __('Not Found'))
@section('extra_message','This requested URL was not found on this server')
