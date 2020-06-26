@extends('admin.turkey.dashboard')
@section('styles')
    @parent
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/css/tempusdominus-bootstrap-4.min.css" />
@endsection
@section('dash_content')
<div class="container mt-4">
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Pen</li>
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
                <div class="alert alert-error col-md-12" role="alert">
                    <span>{{ session()->get('error')}} </span>
                </div>
               @endif
               @if ($errors->any())
                    <div class="alert alert-danger col-md-12" >
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
               <span>
                   <button type="button" class="btn btn-sm btn-primary"  data-toggle="modal" data-target="#addPenModal">
                        Add Pen
                    </button>
                </span>
                {{-- <span>
                    <a href="{{route('export.sales.birds','turkey')}}"  class="btn btn-sm btn-primary ml-2">Export Data</a>
                </span> --}}
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
                                        <input type="text"  name="id" id="id" class="form-control @error('id') is-invalid @enderror" value="{{old('id') ? old('id'): generate_pen_id('turkey')}}">
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
                                        <input type="number" min="0.00" step="0.01" name="size" id="size" class="form-control @error('size') is-invalid @enderror" value="{{old('size')}}">
                                        @error('size')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="price">Bird Capacity</label>
                                        <input type="number" name="capacity" min="0" step="1" class="form-control @error('capacity') is-invalid @enderror" id="capacity" value="{{ old('capacity') }}">
                                        @error('capacity')
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
                            {{-- <th>Farm</th> --}}
                            <th>Location</th>
                            <th>Size (sq ft)</th>
                            <th>Bird Capacity</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Pen ID</th>
                            {{-- <th>Farm</th> --}}
                            <th>Location</th>
                            <th>Size (sq ft)</th>
                            <th> Bird Capacity</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
    {{-- edit form modal --}}
        <div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="editModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalCenterTitle">Edit Record</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="editPenForm" method="POST" action="/edit">
                            @csrf
                            @method('PUT')
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="edit_pen_id">ID</label>
                                    <input type="text"  name="pen_id" id="edit_pen_id" class="form-control @error('pen_id') is-invalid @enderror" value="{{old('pen_id')}}">
                                    @error('pen_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="edit_pen_location">Location</label>
                                    <input type="text" name="pen_location" id="edit_pen_location" class="form-control @error('pen_location') is-invalid @enderror" value="{{old('pen_location')}}">
                                    @error('pen_location')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="edit_pen_size">Size (sq ft)</label>
                                    <input type="number" min="0.00" step="0.01" name="pen_size" id="edit_pen_size" class="form-control @error('pen_size') is-invalid @enderror" value="{{old('pen_size')}}">
                                    @error('pen_size')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="edit_pen_capacity">Bird Capacity</label>
                                    <input type="number" name="pen_capacity" min="0" class="form-control @error('pen_capacity') is-invalid @enderror" id="edit_pen_capacity" value="{{ old('pen_capacity') }}">
                                    @error('pen_capacity')
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
                    <button type="button" onclick="document.getElementById('editPenForm').submit()" class="btn btn-primary">Update</button>
                </div>
                </div>
            </div>
        </div>
</div>
@endsection

@section('script-tags')
@parent
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment-with-locales.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/js/tempusdominus-bootstrap-4.min.js"></script>
@endsection
@section('script')
    @parent

    $('#datetimepicker1').datetimepicker({
        format: 'L',
        icons: {
        time: "fa fa-clock",
        date: "fa fa-calendar",
        up: "fa fa-arrow-up",
        down: "fa fa-arrow-down"
    }});
    let table = $('#dataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('datatables.pen','turkey') }}",
            columns: [
                {data:'pen_id',name:'pen_id'},
                {data:'location',name:'location'},
                {data:'size',name:'size'},
                {data:'capacity',name:'capacity'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });

      table.on('click','.edit-btn',(e)=>{
        var tr = $(e.target).closest('tr');
        var pen_data = table.row(tr).data();
        $('#edit_pen_id').val(pen_data.pen_id);
        $('#edit_pen_location').val(pen_data.location);
        $('#edit_pen_size').val(pen_data.size);
        $('#edit_pen_capacity').val(pen_data.capacity)
        $('#editPenForm').attr('action',`/edit/pen/${pen_data.pen_id}`)
        $('#edit-modal').modal('show');
    });

     table.on('click','.delete-btn', (e)=>{
       if (confirm("Are you shure you want to delete record\nThis action will lead to permanent loss of data")) {
            let form = $(e.target).closest('form');
            form.submit();
        }
    });
@endsection

