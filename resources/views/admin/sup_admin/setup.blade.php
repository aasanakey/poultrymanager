@extends('layouts.app')
@section('styles')
@parent
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
@endsection
@section('content')
    {{-- @include('layouts.logo') --}}
    <div class="container-fluid mt-4">
            <div class="mb-4">
                <h3 class="card-title center">Please Add Pen House to get started</h3>
            </div>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Pen House</li>
                <li class="breadcrumb-item">Birds</li>
            </ol>
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        @if (session()->has('success'))
                        <div class="alert alert-success col-md-12" role="alert">
                            <span>{{ session()->get('success')}} </span>
                        </div>
                        @endif
                        @if (session()->has('error'))
                        <div class="alert alert-error" role="alert">
                            <span>{{ session()->get('error')}} </span>
                        </div>
                        @endif
                        <span>
                            <button type="button" class="btn btn-sm btn-primary"  data-toggle="modal" data-target="#addPenModal">
                                Add Pen House
                            </button>
                        </span>
                    </div>
                    {{-- modal --}}
                    <div class="modal fade" id="addPenModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalCenterTitle">Enter Detials</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="penForm" method="POST" action="{{ route('admin.add.pen')}}">
                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="exampleFormControlSelect2">ID</label>
                                            <input type="text"  name="id" id="id" class="form-control @error('id') is-invalid @enderror" value="{{old('id') ? old('id'): generate_pen_id()}}">
                                            @error('id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="location">Location</label>
                                            <input type="text" name="location" id="location" class="form-control @error('location') is-invalid @enderror" value="{{old('location')}}">
                                            @error('location')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="exampleFormControlSelect2">Size (sq ft)</label>
                                            <input type="number" min="0" name="size" id="size" class="form-control @error('size') is-invalid @enderror" value="{{old('size')}}">
                                            @error('size')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="price">Bird Capacity</label>
                                            <input type="number" name="capacity" min="0" class="form-control @error('capacity') is-invalid @enderror" id="capacity" value="{{ old('capacity') }}">
                                            @error('capacity')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                             <label for="bird_type">Bird Type</label>
                                            <select name="bird_type" class="form-control @error('bird_type') is-invalid @enderror" id="bird_type">
                                                <option value=""></option>
                                                <option value="chicken">Chicken</option>
                                                <option value="turkey">Turkey</option>
                                                <option value="guinea_fowl">Guinea Fowl</option>
                                            </select>
                                            @error('bird_type')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" onclick="document.getElementById('penForm').submit()" class="btn btn-primary">Submit</button>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header"><i class="fas fa-home mr-1"></i>Pen Houses</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Pen ID</th>
                                    <th>Farm</th>
                                    <th>Location</th>
                                    <th>Size</th>
                                    <th>Capacity</th>
                                    <th>Bird Type</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Pen ID</th>
                                    <th>Farm</th>
                                    <th>Location</th>
                                    <th>Size</th>
                                    <th>Capacity</th>
                                    <th>Bird Type</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
                <hr>
                <div class="" style="display:flex; justify-content:center;">
                    <div class="" >
                        <ul class="pagination">
                            {{-- <li class="page-item"><a class="btn btn-primary" href="{{url('/dashboard')}}">Previous</a></li> --}}
                            <li class="page-item"><a class="btn btn-primary" href="{{route('setup.bird')}}" class="btn btn-primary btn-sm">Next</a></li>
                        </ul>
                    </div>
                </div>
            </div>
    </div>

@endsection

@section('script-tags')
@parent
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
@endsection
@section('script')
    @parent
    $('#dataTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('datatables.pen','all') }}",
        columns: [
            {data:'pen_id',name:'pen_id'},
            {data: 'farm_name', name: 'Farm'},
            {data:'location',name:'Location'},
            {data:'size',name:'Size'},
            {data:'capacity',name:'Capacity'},
            {data:'bird_type',name:'Bird Type'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
@endsection
