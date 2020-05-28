@extends('admin.sup_admin.guineafowl.dashboard')
@section('styles')
    @parent
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/css/tempusdominus-bootstrap-4.min.css" />
@endsection
@section('dash_content')
<div class="container mt-4">
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Users</li>
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
                   <button type="button" class="btn btn-sm btn-primary"  data-toggle="modal" data-target="#addMortalityModal">
                        New User
                    </button>
                </span>
                {{-- <span>
                    <a href="{{route('export.employees','guinea_fowl')}}"  class="btn btn-sm btn-primary ml-2">Export Data</a>
                </span> --}}
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
                        <form id="mortalityForm" method="POST" action="{{ route('admin.add.employee')}}">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="name">Full name</label>
                                    <input type="text" name="full_name" class="form-control  @error('full_name') is-invalid @enderror" id="name" value="{{old('full_name')}}">
                                    @error('full_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="id">Employee ID/No</label>
                                    <input type="text" name="id"  class="form-control @error('id') is-invalid @enderror" id="disease" value="{{ old('disease') ?? uniqid(true).'__'.auth()->user()->farm_id }}">
                                    @error('id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="date">Date of Birth</label>
                                    <div class="input-group date" id="datetimepicker1" data-target-input="nearest">
                                        <input type="text" name="dob" class="form-control datetimepicker-input  @error('dob') is-invalid @enderror"
                                        data-target="#datetimepicker1" value="{{ old('dob')}}"/>
                                        <div class="input-group-append" data-target="#datetimepicker1" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                        @error('dob')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" class="form-control  @error('email') is-invalid @enderror" value="{{ old('email')}}"/>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="hire_date">Employment Date</label>
                                    <div class="input-group date" id="hire_date_datetimepicker1" data-target-input="nearest">
                                        <input type="text" name="hire_date" class="form-control datetimepicker-input  @error('hire_date') is-invalid @enderror"
                                        data-target="#hire_date_datetimepicker1" value="{{ old('hire_date')}}"/>
                                        <div class="input-group-append" data-target="#hire_date_datetimepicker1" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                        @error('hire_date')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                {{-- <div class="form-group col-md-6">
                                    <label for="photo">Picture</label>
                                    <input type="file" name="photo" class="form-control  @error('photo') is-invalid @enderror" value="{{ old('email')}}"/>
                                        @error('photo')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                </div> --}}
                                <div class="form-group col-md-6">
                                        <label  for="contact">Contact</label>
                                        <input class="form-control @error('contact') is-invalid @enderror" id="contact"
                                        type="text"  name="contact" value="{{ old('contact') }}" placeholder="233 210 000 210" aria-describedby="contact_error"/>

                                    @error('contact')
                                        <span id="farm_contact_error" class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="jd">Job Description</label>
                                    <textarea name="jd" id="jd" class="form-control @error('jd') is-invalid @enderror" cols="30" rows="5">{{ old('jd')}}</textarea>
                                    @error('jd')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <input type="text" name="category" value="guinea_fowl" hidden>
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
        <div class="card-header"><i class="fas fa-table mr-1"></i>tables</div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Age</th>
                            <th>Appointment Date</th>
                            <th>Job Description</th>
                            <th>Photo</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Age</th>
                            <th>Appointment Date</th>
                            <th>Job Description</th>
                            <th>Photo</th>
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
    $('#datetimepicker1,#hire_date_datetimepicker1').datetimepicker({
        icons: {
        time: "fa fa-clock",
        date: "fa fa-calendar",
        up: "fa fa-arrow-up",
        down: "fa fa-arrow-down"
    }});
    $('#dataTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('datatables.admins','guinea_fowl') }}",
        columns: [
            {data: 'id', name: 'ID'},
            {{-- {data: 'employee_id', name: 'ID'}, --}}
            {data:'full_name',name:'Name'},
            {data:'email',name:'Email'},
            {data: 'dob', name: 'Age'},
            {data:'hire_date',name:'Appointment Date'},
            {data:'jd',name:'Job Description'},
            {data:'photo',name:'Photo'},
            {data: 'action', name: 'Action', orderable: false, searchable: false},
        ]
    });
@endsection

