@extends('admin.chicken.dashboard')
@section('styles')
    @parent
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/css/tempusdominus-bootstrap-4.min.css" />
@endsection
@section('dash_content')
<div class="container mt-4">
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Population</li>
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
                   <button type="button" class="btn btn-sm btn-primary"  data-toggle="modal" data-target="#addBirdModal">
                        Add Bird
                    </button>
                </span>
                <span>
                    <a  href="{{route('export.birds','chicken')}}" class="btn btn-sm btn-primary ml-2">Export Data</a>
                </span>
           </div>
          {{-- modal --}}
          <div class="modal fade" id="addBirdModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalCenterTitle">Enter Detials</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="birdForm" method="POST" action="{{ route('admin.add.bird','chicken')}}">
                                @csrf
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="exampleFormControlSelect1">Species</label>
                                        <select name="species" class="form-control" id="exampleFormControlSelect1">
                                        <option value="Rhode Island Reds">Rhode Island Reds</option>
                                        <option value="Sussex">Sussex</option>
                                        <option value="Plymouth">Plymouth/Barred Rock</option>
                                        <option value="Australorp">Australorp</option>
                                        <option value="Wyandotte">Wyandotte</option>
                                        <option value="Jersey Giant">Jersey Giant</option>
                                        <option value="Leghorn">Leghorn</option>
                                        <option value="Orpington">Orpington</option>
                                        <option value="Barnevelder">Barnevelder</option>
                                        <option value="Marans">Marans</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="exampleFormControlSelect2">type</label>
                                        <select name="type" class="form-control" id="exampleFormControlSelect2">
                                            <option value="layer">Layer</option>
                                            <option value="broiler">Broiler</option>
                                        </select>
                                        @error('type')
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
                                        <label for="number">Number of Birds</label>
                                        <input type="number" name="number" min="0" class="form-control @error('number') is-invalid @enderror" id="number" value="{{ old('number') }}">
                                        @error('number')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="price">Price per Bird(GHS &#162;)</label>
                                        <input type="number" name="price" min="0" step="0.01" class="form-control @error('price') is-invalid @enderror" id="price" value="{{ old('price') }}">
                                        @error('price')
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
                            <button type="button" onclick="document.getElementById('birdForm').submit()" class="btn btn-primary">Submit</button>
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
                            <th>Pen</th>
                            <th>Number of Birds</th>
                            <th>Price per Bird(GHS &#162;)</th>
                            <th>Species</th>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                                <th>Batch</th>
                                <th>Pen</th>
                                <th>Number of Birds</th>
                                <th>Price per Bird (GHS &#162;)</th>
                                <th>Species</th>
                                <th>Date</th>
                                <th>Type</th>
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
                                <label for="edit_species">Breed</label>
                                <input type="text" name="bird_species" class="form-control @error('bird_species') is-invalid @enderror" id="edit_species" value="{{ old('bird_species') }}"  />
                                @error('bird_species')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="edit_type">type</label>
                                <input name="bird_type" class="form-control @error('bird_type') is-invalid @enderror" value="{{ old('bird_type') }}" id="edit_type" />

                                @error('bird_type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="edit_pen">Pen House</label>
                                    <input  type="text" name="bird_pen" class="form-control @error('bird_pen') is-invalid @enderror" value="{{ old('bird_pen') }}" id="edit_pen">
                                @error('bird_pen')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="edit_number">Number of Birds</label>
                                <input type="number" name="bird_number" min="0" class="form-control @error('bird_number') is-invalid @enderror" id="edit_number" value="{{ old('bird_number') }}">
                                @error('bird_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="edit_price">Price per Bird(GHS &#162;)</label>
                                <input type="number" name="bird_price" min="0" step="0.01" class="form-control @error('price') is-invalid @enderror" id="edit_price" value="{{ old('bird_price') }}">
                                @error('bird_price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="edit_datetimepicker">Date</label>
                                <div class="input-group date" id="edit_datetimepicker" data-target-input="nearest">
                                    <input type="text" name="bird_date" id="edit_date" class="form-control datetimepicker-input  @error('bird_date') is-invalid @enderror"
                                    data-target="#edit_datetimepicker" value="{{ old('bird_date')}}"/>
                                    <div class="input-group-append" data-target="#edit_datetimepicker" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                    @error('bird_date')
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
                <button type="button" onclick="document.getElementById('editPenForm').submit()" class="btn btn-primary">Update</button>
            </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script-tags')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment-with-locales.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/js/tempusdominus-bootstrap-4.min.js"></script>
@endsection
@section('script')
    @parent
    $('#datetimepicker1,#edit_datetimepicker').datetimepicker({
        format: 'L',
        icons: {
        time: "fa fa-clock",
        date: "fa fa-calendar",
        up: "fa fa-arrow-up",
        down: "fa fa-arrow-down"
    }
    });
    let table = $('#dataTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('datatables.population','chicken') }}",
        columns: [
            {data: 'batch_id', name: 'batch_id'},
            {data:'pen_id',name:'pen_id'},
            {data:'number',name:'number'},
            {data:'unit_price',name:'unit_price'},
            {data:'species',name:'species'},
            {data:'date',name:'date'},
            {data:'type',name:'type'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });

    table.on('click','.edit-btn',(e)=>{
        var tr = $(e.target).closest('tr');
        var bird_data = table.row(tr).data();
        $('#edit_species').val(bird_data.species);
        $('#edit_type').val(bird_data.type);
        $('#edit_pen').val(bird_data.pen_id);
        $('#edit_number').val(bird_data.number);
        $('#edit_price').val(bird_data.unit_price);
        let date = new Date(bird_data.date);
        $('#edit_date').val(date.format())
        $('#editPenForm').attr('action',`/edit/bird/${bird_data.batch_id}`)
        $('#edit-modal').modal('show');
    });

    table.on('click','.delete-btn', (e)=>{
       if (confirm("Are you shure you want to delete record\nThis action will lead to permanent loss of data")) {
            let form = $(e.target).closest('form');
            form.submit();
        }
    });
@endsection
