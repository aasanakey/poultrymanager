@extends('admin.chicken.dashboard')
@section('styles')
    @parent
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/css/tempusdominus-bootstrap-4.min.css" />
@endsection
@section('dash_content')
<div class="container mt-4">
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Mortality</li>
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
                        Add Mortality
                    </button>
                </span>
                <span>
                    <a href="{{route('export.mortality','chicken')}}"  class="btn btn-sm btn-primary ml-2">Export Data</a>
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
                        <form id="mortalityForm" method="POST" action="{{ route('admin.add.mortality','chicken')}}">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="batch_id">Batch id</label>
                                    @if (isset($batch_id))
                                    <select name="batch_id" class="form-control" id="batch_id">
                                    @foreach ($batch_id as $item)
                                            <option value="{{$item->batch_id}}">{{$item->batch_id}}</option>
                                    @endforeach
                                    </select>
                                @else
                                <input type="text" name="batch_id" class="form-control  @error('batch_id') is-invalid @enderror" id="batch_id" value="{{old('batch_id')}}">
                                @endif
                                    @error('batch_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="exampleFormControlSelect2">Number of death</label>
                                        <input type="number" name="number" min="0" class="form-control @error('number') is-invalid @enderror" value="{{old('number')}}">
                                        @error('number')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="pen">Pen House</label>
                                    @if (isset($pen))
                                        <select name="pen" class="form-control" id="pen">
                                        @foreach ($pen as $item)
                                                <option value="{{$item->pen_id}}">{{$item->pen_id}}</option>
                                        @endforeach
                                        </select>
                                    @else
                                    <input type="text" name="pen"  class="form-control @error('pen') is-invalid @enderror" id="pen" value="{{ old('pen') }}">
                                    @endif
                                    @error('pen')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="unit_price">Cost Price per Bird</label>
                                    <input type="number" name="unit_price" id="unit_price" min="0" class="form-control @error('unit_price') is-invalid @enderror" value="{{old('unit_price')}}">
                                    @error('unit_price')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="cause">Cause</label>
                                    <input type="text" name="cause" class="form-control @error('cause') is-invalid @enderror" id="cause" value="{{ old('cause') }}">
                                    @error('cause')
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
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                        <label for="cause">Observation</label>
                                        <textarea name="observation"  class="form-control @error('observation') is-invalid @enderror" id="observation">
                                        {{ old('observation') }}
                                        </textarea>
                                        @error('observation')
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
                      <button type="button" onclick="document.getElementById('mortalityForm').submit()" class="btn btn-primary">Submit</button>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-header"><i class="fas fa-table mr-1"></i>Birds</div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Batch</th>
                            <th>Farm</th>
                            <th>Pen House</th>
                            <th>Number</th>
                            <th>Cause</th>
                            <th>Observation</th>
                            <th>Price</th>
                            <th>Date</th>
                            {{-- <th>Type</th> --}}
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Batch</th>
                            <th>Farm</th>
                            <th>Pen House</th>
                            <th>Number</th>
                            <th>Cause</th>
                            <th>Observation</th>
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
    {{-- @if ($errors)
        {{!!"$('#addBirdModal').modal('show');"!!}}
    @endif --}}
    $('#datetimepicker1').datetimepicker({
       format: 'L',
        icons: {
        time: "fa fa-clock",
        date: "fa fa-calendar",
        up: "fa fa-arrow-up",
        down: "fa fa-arrow-down"
    }});
    $('#dataTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('datatables.mortality','chicken') }}",
        columns: [
            {data: 'batch_id', name: 'batch_id'},
            {data: 'farm_name', name: 'Farm'},
            {data:'pen_id',name:'Pen House'},
            {data:'number',name:'Number'},
            {data:'cause',name:'Cause'},
            {data:'observation',name:'Observation'},
            {data:'unit_price',name:'Price'},
            {data:'dod',name:'Date'},
            {data: 'action', name: 'Action', orderable: false, searchable: false},
        ]
    });
@endsection
