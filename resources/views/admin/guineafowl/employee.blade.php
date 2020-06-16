@extends('admin.guineafowl.dashboard')
@section('styles')
    @parent
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/css/tempusdominus-bootstrap-4.min.css" />
@endsection
@section('dash_content')
<div class="container mt-4">
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Employee</li>
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
                        Add Employee
                    </button>
                </span>
                <span>
                    <a href="{{route('export.employees','guinea_fowl')}}"  class="btn btn-sm btn-primary ml-2">Export Data</a>
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
                                    <input type="text" name="id"  class="form-control @error('id') is-invalid @enderror" id="id" value="{{ old('id') ?? uniqid(true).'__'.auth()->user()->farm_id }}">
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
        <div class="card-header"><i class="fas fa-table mr-1"></i>Employees</div>
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
                            {{-- <th>Photo</th> --}}
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
                            {{-- <th>Photo</th> --}}
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
                                    <label for="_name">Full name</label>
                                    <input type="text" name="_full_name" class="form-control  @error('_full_name') is-invalid @enderror" id="_name" value="{{old('_full_name')}}">
                                    @error('_full_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="_id">Employee ID/No</label>
                                    <input type="text" name="_id"  class="form-control @error('_id') is-invalid @enderror" id="_id" value="{{ old('_id') }}">
                                    @error('_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="_date">Date of Birth</label>
                                    <div class="input-group date" id="_datetimepicker1" data-target-input="nearest">
                                        <input type="text" name="_dob" class="form-control datetimepicker-input  @error('dob') is-invalid @enderror"
                                        data-target="#_datetimepicker1" id="_date" value="{{ old('_dob')}}"/>
                                        <div class="input-group-append" data-target="#_datetimepicker1" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                        @error('_dob')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="_email">Email</label>
                                    <input type="email" name="_email" class="form-control  @error('_email') is-invalid @enderror" id="_email" value="{{ old('_email')}}"/>
                                        @error('_email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="_hire_date">Employment Date</label>
                                    <div class="input-group date" id="_hire_date_datetimepicker1" data-target-input="nearest">
                                        <input type="text" name="_hire_date" id="_hire_date" class="form-control datetimepicker-input  @error('_hire_date') is-invalid @enderror"
                                        data-target="#_hire_date_datetimepicker1" value="{{ old('_hire_date')}}"/>
                                        <div class="input-group-append" data-target="#_hire_date_datetimepicker1" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                        @error('_hire_date')
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
                                        <label  for="_contact">Contact</label>
                                        <input class="form-control @error('_contact') is-invalid @enderror" id="_contact"
                                        type="text"  name="_contact" value="{{ old('_contact') }}" placeholder="233 210 000 210" />

                                    @error('_contact')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="_jd">Job Description</label>
                                    <textarea name="_jd" id="_jd" class="form-control @error('_jd') is-invalid @enderror" cols="30" rows="5">{{ old('_jd')}}</textarea>
                                    @error('_jd')
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
   
    $('#datetimepicker1,#hire_date_datetimepicker1,#_datetimepicker1,#_hire_date_datetimepicker1').datetimepicker({
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
                ajax: "{{ route('datatables.employees','guinea_fowl') }}",
                columns: [
                    {data: 'employee_id', name: 'employee_id'},
                    {data:'full_name',name:'full_name'},
                    {data:'email',name:'email'},
                    {data: 'age', name: 'age'},
                    {data:'hire_date',name:'hire_date'},
                    {data:'jd',name:'jd'},
                    {{-- {data:'photo',name:'photo'}, --}}
                    {data: 'action', name: 'Action', orderable: false, searchable: false},
                ]
            });
  table.on('click','.edit-btn',(e)=>{
        var tr = $(e.target).closest('tr');
        var data = table.row(tr).data();
        $('#_name').val(data.full_name);
        $('#_id').val(data.employee_id);
        $('#_email').val(data.email);
        $('#_jd').val(data.jd);
         $('#_contact').val(data.contact)
        let date = new Date(data.dob);
        $('#_date').val(date.format());
        date = new Date(data.hire_date)
        $('#_hire_date').val(date.format());
        $('#editPenForm').attr('action',`/edit/employee/${data.id}`)
        $('#edit-modal').modal('show');
    });

    table.on('click','.delete-btn', (e)=>{
        if (confirm("Are you shure you want to delete record\nThis action will lead to permanent loss of data")) {
                let form = $(e.target).closest('form');
                form.submit();
            }
        });
@endsection

