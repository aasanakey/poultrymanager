@extends('admin.chicken.dashboard')
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
                    <a href="{{route('admin.bird.population','chicken')}}" class="offer-img">
                        <i class="fas fa-crow fa-8x"></i>
                    </a>
                    <h6><a href="{{route('admin.bird.population','chicken')}}">Population</a></h6>
                </div>
            </div>


            <div class="col-sm-3">
                <div class="center">
                    <a href="{{route('admin.egg.production','chicken')}}" class="offer-img">
                       <i class="fas fa-egg fa-8x"></i>
                    </a>
                    <h6><a href="{{route('admin.egg.production','chicken')}}">Egg Production</a></h6>
                </div>
            </div>


            <div class="col-sm-3">
                <div class="center">
                    <a href="{{ route('admin.medicine','chicken')}}" data-toggle="modal" data-target="#myModal1" class="offer-img">
                        <i class="fas fa-tablets fa-8x"></i>
                    </a>
                    <h6><a href="{{ route('admin.medicine','chicken')}}">Medication</a></h6>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="center">
                    <a href="{{ route('admin.feed.stock','chicken')}}" data-toggle="modal" data-target="#myModal1" class="offer-img">
                            <i class="fas fa-cookie-bite fa-8x"></i>
                    </a>
                    <h6><a href="{{ route('admin.feed.stock','chicken')}}">Feed</a></h6>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-3">
                <div class="center">
                    <a href="{{ route('admin.employee','chicken')}}" data-toggle="modal" data-target="#myModal1" class="offer-img">
                        <i class="fas fa-user-friends fa-8x"></i>
                    </a>
                    <div class="">
                        <div class="">
                            <h6><a href="{{ route('admin.employee','chicken')}}">Employees</a></h6>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="center">
                    <a href="{{ route('admin.sale.bird','chicken')}}" data-toggle="modal" data-target="#myModal1" class="offer-img">
                        <i class="fas fa-money-bill-alt fa-8x"></i>
                    </a>
                    <div class="">
                        <div class="">
                            <h6><a href="{{ route('admin.sale.all','chicken')}}">Sales</a></h6>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="center">
                <a href="{{route('admin.farm.equipment','chicken')}}" data-toggle="modal" data-target="#myModal1" class="offer-img">
                        <i class="fas fa-tools fa-8x"></i>
                    </a>
                    <div class="mid-1">
                        <div class="women">
                            <h6><a href="{{route('admin.farm.equipment','chicken')}}">Equipment</a></h6>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="center">
                <a href="{{route('admin.statement','chicken')}}" data-toggle="modal" data-target="#myModal1" class="offer-img">
                        <i class="fas fa-poll fa-8x"></i>
                    </a>
                    <div class="mid-1">
                        <div class="women">
                            <h6><a href="{{route('admin.statement','chicken')}}">Reports</a></h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
