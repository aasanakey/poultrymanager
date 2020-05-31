@extends('admin.turkey.dashboard')
@section('styles')
    <style>
        .col-sm-3{
            border: 1px solid #00f3fe;
            padding-top: 10px;
        }
    </style>
@endsection
@section('dash_content')
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-sm-3">
                <div class="center">
                    <a href="{{route('admin.bird.population','turkey')}}" class="offer-img">
                        <i class="fas fa-crow fa-8x"></i>
                    </a>
                    <h6><a href="{{route('admin.bird.population','turkey')}}">Population</a></h6>
                </div>
            </div>


            <div class="col-sm-3">
                <div class="center">
                    <a href="{{route('admin.egg.production','turkey')}}" class="offer-img">
                       <i class="fas fa-egg fa-8x"></i>
                    </a>
                    <h6><a href="{{route('admin.egg.production','turkey')}}">Egg Production</a></h6>
                </div>
            </div>


            <div class="col-sm-3">
                <div class="center">
                    <a href="{{route('admin.medicine','turkey')}}" data-toggle="modal" data-target="#myModal1" class="offer-img">
                        <i class="fas fa-tablets fa-8x"></i>
                    </a>
                    <h6><a href="{{route('admin.medicine','turkey')}}">Medication</a></h6>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="center">
                    <a href="{{route('admin.feed.stock','turkey')}}" data-toggle="modal" data-target="#myModal1" class="offer-img">
                            <i class="fas fa-cookie-bite fa-8x"></i>
                    </a>
                    <h6><a href="{{route('admin.feed.stock','turkey')}}">Feed</a></h6>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-3">
                <div class="center">
                    <a href="{{route('admin.employee','turkey')}}" data-toggle="modal" data-target="#myModal1" class="offer-img">
                        <i class="fas fa-user-friends fa-8x"></i>
                    </a>
                    <div class="">
                        <div class="">
                            <h6><a href="{{route('admin.employee','turkey')}}">Employees</a></h6>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="center">
                    <a href="{{route('admin.sale.bird','turkey')}}" data-toggle="modal" data-target="#myModal1" class="offer-img">
                        <i class="fas fa-money-bill-alt fa-8x"></i>
                    </a>
                    <div class="">
                        <div class="">
                            <h6><a href="{{route('admin.sale.bird','turkey')}}">Sales</a></h6>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="center">
                <a href="#" data-toggle="modal" data-target="#myModal1" class="offer-img">
                        <i class="fas fa-tools fa-8x"></i>
                    </a>
                    <div class="mid-1">
                        <div class="women">
                            <h6><a href="single.html">Equipment</a></h6>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="center">
                <a href="{{route('admin.report','turkey')}}" data-toggle="modal" data-target="#myModal1" class="offer-img">
                        <i class="fas fa-poll fa-8x"></i>
                    </a>
                    <div class="mid-1">
                        <div class="women">
                            <h6><a href="{{route('admin.report','turkey')}}">Reports</a></h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
