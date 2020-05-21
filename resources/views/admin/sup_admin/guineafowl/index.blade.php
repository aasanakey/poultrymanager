@extends('admin.sup_admin.chicken.dashboard')
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
                    <a href="{{route('admin.bird.population','guinea_fowl')}}" class="offer-img">
                        <i class="fas fa-crow fa-8x"></i>
                    </a>
                    <h6><a href="{{route('admin.bird.population','guinea_fowl')}}">Population</a></h6>
                </div>
            </div>


            <div class="col-sm-3">
                <div class="center">
                    <a href="{{route('admin.egg.production','guinea_fowl')}}" class="offer-img">
                       <i class="fas fa-egg fa-8x"></i>
                    </a>
                    <h6><a href="{{route('admin.egg.production','guinea_fowl')}}">Egg Production</a></h6>
                </div>
            </div>


            <div class="col-sm-3">
                <div class="center">
                    <a href="{{route('admin.medicine','guinea_fowl')}}" data-toggle="modal" data-target="#myModal1" class="offer-img">
                        <i class="fas fa-tablets fa-8x"></i>
                    </a>
                    <h6><a href="{{route('admin.medicine','guinea_fowl')}}">Medication</a></h6>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="center">
                    <a href="{{route('admin.feed.stock','guinea_fowl')}}" data-toggle="modal" data-target="#myModal1" class="offer-img">
                            <i class="fas fa-cookie-bite fa-8x"></i>
                    </a>
                    <h6><a href="{{route('admin.feed.stock','guinea_fowl')}}">Feed</a></h6>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-3">
                <div class="center">
                    <a href="{{route('admin.employee','guinea_fowl')}}" data-toggle="modal" data-target="#myModal1" class="offer-img">
                        <i class="fas fa-user-friends fa-8x"></i>
                    </a>
                    <div class="">
                        <div class="">
                            <h6><a href="{{route('admin.employee','guinea_fowl')}}">Employees</a></h6>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="center">
                    <a href="{{route('admin.sale.bird','guinea_fowl')}}" data-toggle="modal" data-target="#myModal1" class="offer-img">
                        <i class="fas fa-money-bill-alt fa-8x"></i>
                    </a>
                    <div class="">
                        <div class="">
                            <h6><a href="{{route('admin.sale.bird','guinea_fowl')}}">Sales</a></h6>
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
                <a href="#" data-toggle="modal" data-target="#myModal1" class="offer-img">
                        <i class="fas fa-poll fa-8x"></i>
                    </a>
                    <div class="mid-1">
                        <div class="women">
                            <h6><a href="{{route('admin.bird.population','guinea_fowl')}}">Reports</a></h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
