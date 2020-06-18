@extends('layouts.app')
@section('styles')
    @parent
    <style>
        img.card-img-top{
            height: 300px;
            /* width: inherit; */
        }
    </style>
@endsection
@section('content')
@include('layouts.logo')
    <div class="container">
        <div class="div">
            <a class="btn btn-primary" href="{{ route('admin.logout') }}"  onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> <i class="fas fa-sign-out-alt"></i>logout</a>
            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
        <div class="row mt-4" style="margin-bottom:10px;">
            <div class="card col-md-4">
                <a href="{{route('admin.bird_type','chicken')}}">
                    <img src="{{asset('/images/chicken.jpg')}}" class="card-img-top" alt="chicken">
                </a>
                <div class="card-body center">
                  <a href="{{route('admin.bird_type','chicken')}}" class="btn btn-primary">Chicken</a>
                </div>
            </div>
            <div class="card col-md-4" >
                <a href="{{route('admin.bird_type','guinea_fowl')}}">
                    <img src="{{asset('/images/guinea_fowl.jpg')}}" class="card-img-top" alt=".guinea fowl">
                </a>
                <div class="card-body center">
                  <a href="{{route('admin.bird_type','guinea_fowl')}}" class="btn btn-primary">Guinea Fowl</a>
                </div>
            </div>
            <div class="card col-md-4" >
                <a href="{{route('admin.bird_type','turkey')}}">
                    <img src="{{asset('/images/turkey.jpg')}}" class="card-img-top" alt="turkey">
                </a>
                <div class="card-body center">
                  <a href="{{route('admin.bird_type','turkey')}}" class="btn btn-primary">Turkey</a>
                </div>
            </div>
        </div>
    </div>
@endsection
