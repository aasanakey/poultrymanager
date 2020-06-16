@extends('admin.guineafowl.dashboard')
@section('styles')
    @parent
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/css/tempusdominus-bootstrap-4.min.css" />
@endsection
@section('dash_content')
<div class="container mt-4">
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Equipment</li>
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
                    <button type="button" class="btn btn-sm btn-primary"  data-toggle="modal" data-target="#addPenModal">
                        Add Equipment
                    </button>
                </span>
                <span>
                    <a href="{{route('export.equipment','guinea_fowl')}}"  class="btn btn-sm btn-primary ml-2">Export Data</a>
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
                            <form id="penForm" method="POST" action="{{ route('admin.add.equipment','guinea_fowl')}}">
                                @csrf
                                {{-- id, farm_id, equipment, date_acquired, status, description, supplier, price, c_depreciation, created_at, updated_at --}}
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="name">Equipment</label>
                                        <input type="text"  name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{old('name')}}">
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="date_acquired">Date Acquired</label>
                                        <div class="input-group date" id="datetimepicker1" data-target-input="nearest">
                                            <input type="text" name="date_acquired" class="form-control datetimepicker-input  @error('date_acquired') is-invalid @enderror"
                                            data-target="#datetimepicker1" value="{{ old('date_acquired')}}"/>
                                            <div class="input-group-append" data-target="#datetimepicker1" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                            @error('date_acquired')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="price">Price(GHS &#162;)</label>
                                        <input type="number" min="0" step="0.01" name="price" id="price" class="form-control @error('price') is-invalid @enderror" value="{{old('price')}}">
                                        @error('price')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="supplier">Supplier</label>
                                        <input type="text" name="supplier"  class="form-control @error('supplier') is-invalid @enderror" id="supplier" value="{{ old('supplier') }}">
                                        @error('supplier')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="type">Type</label>
                                        <input type="text" name="type" id="type" class="form-control @error('type') is-invalid @enderror" value="{{old('type')}}">
                                        @error('type')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="status">State</label>
                                        <select name="status"  class="form-control @error('status') is-invalid @enderror" id="status" value="{{ old('status') }}">
                                            <option value="">select state</option>
                                            <option value="Functioning">Functioning</option>
                                            <option value="Maintenance">Maintenance/Repair</option>
                                            <option value="Non Functioning">Non Functioning</option>
                                        </select>
                                        @error('supplier')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label for="description">Description</label>
                                        <textarea name="description" id="description" cols="10" rows="5" class="form-control @error('description') is-invalid @enderror" value="{{ old('description') }}"></textarea>
                                         @error('description')
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
        <div class="card-header"><i class="fas fa-home mr-1"></i>Equipment</div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Equipment</th>
                            <th>Type</th>
                            <th>Purchase Date</th>
                            <th>State</th>
                            <th>Price (GHS &#162;)</th>
                            <th>Supplier</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Equipment</th>
                            <th>Type</th>
                            <th>Purchase Date</th>
                            <th>State</th>
                            <th>Price (GHS &#162;)</th>
                            <th>Supplier</th>
                            <th>Description</th>
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
                                        <label for="_name">Equipment</label>
                                        <input type="text"  name="_name" id="_name" class="form-control @error('_name') is-invalid @enderror" value="{{old('_name')}}">
                                        @error('_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="_date_acquired">Date Acquired</label>
                                        <div class="input-group date" id="_datetimepicker1" data-target-input="nearest">
                                            <input type="text" name="_date_acquired" id="_date_acquired" class="form-control datetimepicker-input  @error('_date_acquired') is-invalid @enderror"
                                            data-target="#_datetimepicker1" value="{{ old('_date_acquired')}}"/>
                                            <div class="input-group-append" data-target="#_datetimepicker1" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                            @error('_date_acquired')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="_price">Price(GHS &#162;)</label>
                                        <input type="number" min="0" step="0.01" name="_price" id="_price" class="form-control @error('_price') is-invalid @enderror" value="{{old('_price')}}">
                                        @error('_price')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="_supplier">Supplier</label>
                                        <input type="text" name="_supplier"  class="form-control @error('_supplier') is-invalid @enderror" id="_supplier" value="{{ old('_supplier') }}">
                                        @error('_supplier')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="_type">Type</label>
                                        <input type="text" name="_type" id="_type" class="form-control @error('_type') is-invalid @enderror" value="{{old('_type')}}">
                                        @error('_type')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="_status">State</label>
                                        <input type="text" name="_status"  class="form-control @error('_status') is-invalid @enderror" id="_status" value="{{ old('_status') }}">
                                        @error('_status')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label for="_description">Description</label>
                                        <textarea name="_description" id="_description" cols="10" rows="5" class="form-control @error('_description') is-invalid @enderror" value="{{ old('_description') }}"></textarea>
                                         @error('_description')
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

    $('#datetimepicker1,#_datetimepicker1').datetimepicker({
        format: 'L',
        icons: {
        time: "fa fa-clock",
        date: "fa fa-calendar",
        up: "fa fa-arrow-up",
        down: "fa fa-arrow-down"
    }});
let table =  $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('datatables.equipment','guinea_fowl') }}",
                columns: [
                    {data:'equipment',name:'equipment'},
                    {data:'type',name:'type'},
                    {data:'date_acquired',name:'date_acquired'},
                    {data:'status',name:'status'},
                    {data:'price',name:'price'},
                    {data:'supplier',name:'supplier'},
                    {data:'description',name:'description'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });
    table.on('click','.edit-btn',(e)=>{
        var tr = $(e.target).closest('tr');
        var data = table.row(tr).data();
        $('#_name').val(data.equipment);
        $('#_price').val(data.price);
        $('#_supplier').val(data.supplier);
        $('#_type').val(data.type);
        $('#_status').val(data.status);
         $('#_description').val(data.description)
        let date = new Date(data.date_acquired);
        $('#_date_acquired').val(date.format());
        $('#editPenForm').attr('action',`/edit/equipment/${data.id}`)
        $('#edit-modal').modal('show');
    });

    table.on('click','.delete-btn', (e)=>{
        if (confirm("Are you shure you want to delete record\nThis action will lead to permanent loss of data")) {
                let form = $(e.target).closest('form');
                form.submit();
            }
        });
@endsection

