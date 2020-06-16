@extends('admin.chicken.dashboard')
@section('styles')
    @parent
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/css/tempusdominus-bootstrap-4.min.css" />
@endsection
@section('dash_content')
<div class="container mt-4">
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Feeding</li>
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
                <div class="alert alert-danger col-md-12" role="alert">
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
                        Add Feeding Record
                    </button>
                </span>
                <span>
                    <a href="{{route('export.feeding','chicken')}}"  class="btn btn-sm btn-primary ml-2">Export Data</a>
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
                        <form id="mortalityForm" method="POST" action="{{ route('admin.add.feeding')}}">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="feed_id">Feed</label>
                                    @if (isset($feed))
                                        <select name="feed_id" class="form-control   @error('feed_id') is-invalid @enderror" id="feed_id">
                                            <option>-- select feed --</option>
                                            @foreach ($feed as $item)
                                                <option value="{{$item->id}}">{{$item->name}}</option>
                                            @endforeach
                                         </select>
                                    @else
                                    <input type="text" name="feed_id" class="form-control  @error('feed_id') is-invalid @enderror" id="feed_id" value="{{old('feed_id')}}">
                                    @endif
                                    @error('feed_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="pen">Pen House</label>
                                    @if (isset($pen))
                                        <select name="pen" class="form-control @error('pen') is-invalid @enderror" id="pen">
                                            <option>-- select pen --</option>
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
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="feed_quantity">Quantity per Serving (Kg)</label>
                                    <input type="number" name="feed_quantity" min="0" step="0.01" class="form-control @error('feed_quantity') is-invalid @enderror" id="feed_quantity" value="{{ old('feed_quantity') }}">
                                    @error('feed_quantity')
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
                                    <label for="water_quantity">Water Quantity (L)</label>
                                    <input type="number" name="water_quantity" min="0" step="0.01" class="form-control @error('water_quantity') is-invalid @enderror" id="water_quantity" value="{{ old('water_quantity') }}">
                                    @error('water_quantity')
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
        <div class="card-header"><i class="fas fa-table mr-1"></i>Feeding</div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Pen House</th>
                            <th>Feed</th>
                            <th>Date & Time</th>
                            <th>Water (l)</th>
                            <th>Feed Quantity (Kg)</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Pen House</th>
                            <th>Feed</th>
                            <th>Date & Time</th>
                            <th>Water (l)</th>
                            <th>Feed Quantity (Kg)</th>
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
                        @method("PUT")
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="_feed_id">Feed</label>
                                <input type="text" name="_feed" class="form-control  @error('_feed') is-invalid @enderror" id="_feed_id" value="{{old('_feed')}}">

                                @error('_feed')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="_pen">Pen House</label>
                                <input type="text" name="_pen"  class="form-control @error('_pen') is-invalid @enderror" id="_pen" value="{{ old('_pen') }}">
                                @error('_pen')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="_feed_quantity">Quantity per Serving (Kg)</label>
                                <input type="number" name="_feed_quantity" min="0" step="0.01" class="form-control @error('_feed_quantity') is-invalid @enderror" id="_feed_quantity" value="{{ old('_feed_quantity') }}">
                                @error('_feed_quantity')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="_date">Date</label>
                                <div class="input-group date" id="_datetimepicker1" data-target-input="nearest">
                                    <input type="text" name="_date" class="form-control datetimepicker-input  @error('_date') is-invalid @enderror"
                                    data-target="#_datetimepicker1" id="_date" value="{{ old('_date')}}"/>
                                    <div class="input-group-append" data-target="#_datetimepicker1" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                    @error('_date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="_water_quantity">Water Quantity (L)</label>
                                <input type="number" name="_water_quantity" min="0" step="0.01" class="form-control @error('_water_quantity') is-invalid @enderror" id="_water_quantity" value="{{ old('_water_quantity') }}">
                                @error('_water_quantity')
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
        {{-- format: 'L', --}}
        icons: {
        time: "fa fa-clock",
        date: "fa fa-calendar",
        up: "fa fa-arrow-up",
        down: "fa fa-arrow-down"
    }});
    let table = $('#dataTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('datatables.feeding','chicken') }}",
        columns: [
            {data: 'pen_id', name: 'pen_id'},
            {data:'name',name:'name'},
            {data:'date',name:'date'},
            {data:'water_quantity',name:'water_quantity'},
            {data:'feed_quantity',name:'feed_quantity'},
            {data: 'action', name: 'Action', orderable: false, searchable: false},
        ]
    });
    table.on('click','.edit-btn',(e)=>{
        var tr = $(e.target).closest('tr');
        var data = table.row(tr).data();
        {{-- console.log(data) --}}
        $('#_feed_id').val(data.name);
        $('#_feed_id').attr('disabled' ,true);
        $('#f_id').val(data.feed_id);
        $('#_pen').val(data.pen_id);
        $('#_feed_quantity').val(data.feed_quantity);
        $('#_water_quantity').val(data.water_quantity);
        let date = new Date(data.date);
        $('#_date').val(date.format())
        $('#editPenForm').attr('action',`/edit/feeding/${data.id}`)
        $('#edit-modal').modal('show');
    });

    table.on('click','.delete-btn', (e)=>{
       if (confirm("Are you shure you want to delete record\nThis action will lead to permanent loss of data")) {
            let form = $(e.target).closest('form');
            form.submit();
        }
    });
@endsection

