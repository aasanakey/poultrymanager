@extends('admin.sup_admin.chicken.dashboard')

@section('dash_content')
    <div class="container mt-4">
        <div class=" row">
            <div class="col-md-3 pro-1">
                <div class="center">
                    <a href="{{route('admin.bird.population','chicken')}}" class="offer-img">
                            {{-- <img src="{{asset('/images/chicken.jpg')}}" alt="chicken" srcset=""> --}}
                        <i class="fas fa-crow fa-8x"></i>
                    </a>
                    <h6><a href="{{route('admin.bird.population','chicken')}}">Population</a></h6>
                </div>
            </div>


            <div class="col-md-3 pro-1">
                <div class="center">
                    <a href="eggproduction.html" class="offer-img">
                       <i class="fas fa-egg fa-8x"></i>
                    </a>
                    <h6><a href="eggproduction.html">Egg Production</a></h6>
                </div>
            </div>


            <div class="col-md-3 pro-1">
                <div class="center">
                    <a href="#" data-toggle="modal" data-target="#myModal1" class="offer-img">
                        <i class="fas fa-tablets fa-8x"></i>
                    </a>
                    <h6><a href="single.html">Medication</a></h6>
                </div>
            </div>
            <div class="col-md-3 pro-1">
                <div class="center">
                    <a href="#" data-toggle="modal" data-target="#myModal1" class="offer-img">
                            <i class="fas fa-cookie-bite fa-8x"></i>
                    </a>
                    <h6><a href="single.html">Feed</a></h6>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 pro-1">
                <div class="center">
                    <a href="#" data-toggle="modal" data-target="#myModal1" class="offer-img">
                        <i class="fas fa-user-friends fa-8x"></i>
                    </a>
                    <div class="">
                        <div class="">
                            <h6><a href="single.html">Employees</a></h6>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 pro-1">
                <div class="center">
                    <a href="#" data-toggle="modal" data-target="#myModal1" class="offer-img">
                        <i class="fas fa-money-bill-alt fa-8x"></i>
                    </a>
                    <div class="">
                        <div class="">
                            <h6><a href="single.html">Sales</a></h6>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 pro-1">
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

            <div class="col-md-3 pro-1">
                <div class="center">
                <a href="#" data-toggle="modal" data-target="#myModal1" class="offer-img">
                        <i class="fas fa-poll fa-8x"></i>
                    </a>
                    <div class="mid-1">
                        <div class="women">
                            <h6><a href="single.html">Reports</a></h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
