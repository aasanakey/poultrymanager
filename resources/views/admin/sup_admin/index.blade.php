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
    <div class="container">
        <div class="row">
            <div class="card col-md-4" style="width: 18rem;">
                <img src="{{asset('/images/chicken.jpg')}}" class="card-img-top" alt="...">
                <div class="card-body">
                  {{-- <h5 class="card-title">Card title</h5>
                  <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p> --}}
                  <a href="{{route('admin.bird_type','chicken')}}" class="btn btn-primary">Chicken</a>
                </div>
            </div>
            <div class="card col-md-4" style="width: 18rem;">
                <img src="{{asset('/images/guinea_fowl.jpg')}}" class="card-img-top" alt="...">
                <div class="card-body">
                  {{-- <h5 class="card-title">Card title</h5>
                  <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p> --}}
                  <a href="{{route('admin.bird_type','guinea_fowl')}}" class="btn btn-primary">Guinea Fowl</a>
                </div>
            </div>
            <div class="card col-md-4" style="width: 18rem;">
                <img src="{{asset('/images/turkey.jpg')}}" class="card-img-top" alt="...">
                <div class="card-body">
                  {{-- <h5 class="card-title">Card title</h5>
                  <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p> --}}
                  <a href="{{route('admin.bird_type','turkey')}}" class="btn btn-primary">Turkey</a>
                </div>
            </div>
        </div>
    </div>
@endsection
