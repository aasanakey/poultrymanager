@extends('admin.guineafowl.dashboard')
@section('styles')
    @parent
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/css/tempusdominus-bootstrap-4.min.css" />
@endsection
@section('dash_content')
<div class="container mt-4">
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Egg Sale</li>
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
                   <button type="button" class="btn btn-sm btn-primary"  data-toggle="modal" data-target="#addMortalityModal">
                        Add Sale
                    </button>
                </span>
                <span>
                    <a href="{{route('export.sales.egg','guinea_fowl')}}"  class="btn btn-sm btn-primary ml-2">Export Data</a>
                </span>
           </div>
           {{-- modal --}}
           <div class="modal fade" id="addMortalityModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalCenterTitle">Enter Detials</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                        <form id="mortalityForm" method="POST" action="{{ route('admin.add.sales.egg','guinea_fowl')}}">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="weight">Weight</label>
                                    <input type="number" name="weight" class="form-control  @error('weight') is-invalid @enderror" id="weight" value="{{old('weight')}}">
                                    @error('weight')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="price">Price</label>
                                    <input type="number" min="0" name="price"  class="form-control @error('price') is-invalid @enderror" id="price" value="{{ old('price') }}">
                                    @error('price')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="quantity">Number of crates</label>
                                    <input type="number" name="quantity" min="0" class="form-control @error('quantity') is-invalid @enderror" id="quantity" value="{{ old('quantity') }}">
                                    @error('quantity')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="date">Date</label>
                                    <div class="input-group date" id="datetimepicker1" data-target-input="nearest">
                                        <input type="text" name="date" class="form-control datetimepicker-input  @error('date') is-invalid @enderror"
                                        data-target="#datetimepicker1" value="{{ old('date')}}"/>
                                        <div class="input-group-append" data-target="#datetimepicker1" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                        @error('date')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      <button type="button" onclick="document.getElementById('mortalityForm').submit()" class="btn btn-primary">Submit</button>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-header"><i class="fas fa-table mr-1"></i>Bird Sale</div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                           <th>Farm</th>
                            <th>Number</th>
                            <th>Weight</th>
                            <th>Price</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Farm</th>
                            <th>Number</th>
                            <th>Weight</th>
                            <th>Price</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody></tbody>
                </table>
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
        icons: {
        time: "fa fa-clock",
        date: "fa fa-calendar",
        up: "fa fa-arrow-up",
        down: "fa fa-arrow-down"
    }});
    $('#dataTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('datatables.sale.egg','guinea_fowl') }}",
        columns: [
            {data: 'farm_name', name: 'farm_name'},
            {data:'quantity',name:'Number'},
            {data:'weight_per_dozen',name:'Weight'},
            {data:'price_per_dozen',name:'Price'},
            {data:'date',name:'Date'},
            {data: 'action', name: 'Action', orderable: false, searchable: false},
        ]
    });
@endsection

