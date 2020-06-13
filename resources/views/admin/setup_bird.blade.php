@extends('layouts.app')
@section('styles')
@parent
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/css/tempusdominus-bootstrap-4.min.css" />
@endsection
@section('content')
<div class="container-fluid mt-4">
        <div class="mb-4">
            <h3 class="card-title center">Please Add Birds to get started</h3>
        </div>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item">Pen House</li>
            <li class="breadcrumb-item active">Birds</li>
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
                        <button type="button" class="btn btn-sm btn-primary"  data-toggle="modal" data-target="#addBirdModal">
                                Add Bird
                            </button>
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
                                <form id="birdForm" method="POST" action="{{ route('admin.add.bird')}}">
                                    @csrf
                                    <div class="form-row" style="display:flex; justify-content:center;">
                                        <fieldset id="bird_category" style="border: 1px solid black;padding:initial;">
                                            <legend style="display:block; font-size:inherit; width:inherit; max-width:inherit;">
                                                Poultry Type</legend>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="bird" id="inlineRadio1" value="chicken">
                                                <label class="form-check-label" for="inlineRadio1">Chicken</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="bird" id="inlineRadio2" value="turkey">
                                                <label class="form-check-label" for="inlineRadio2">Turkey</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="bird" id="inlineRadio3" value="guinea_fowl">
                                                <label class="form-check-label" for="inlineRadio3">Guinea Fowl</label>
                                            </div>
                                        </fieldset>
                                    </div>
                                   <div id="chicken" hidden>
                                        <div class="form-row">
                                            <div class="chicken_form-group col-md-6">
                                                <label for="exampleFormControlSelect1">Breed</label>
                                                <select name="species" class="form-control" id="chicken_exampleFormControlSelect1">
                                                    <option value=""></option>
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
                                                <label for="chicken_exampleFormControlSelect2">type</label>
                                                <select name="type" class="form-control" id="chicken_exampleFormControlSelect2">
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
                                                <label for="chicken_pen">Pen House</label>

                                                    <select name="pen" class="form-control" id="chicken_pen">
                                                    </select>
                                                {{-- <input type="text" name="pen"  class="form-control @error('pen') is-invalid @enderror" id="chicken_pen" value="{{ old('pen') }}">
                                                @endif --}}
                                                @error('pen')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="chicken_number">Number of Birds</label>
                                                <input type="number" name="number" min="0" class="form-control @error('number') is-invalid @enderror" id="chicken_number" value="{{ old('number') }}">
                                                @error('number')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="price">Price per Bird</label>
                                                <input type="number" name="price" min="0" step="0.01" class="form-control @error('price') is-invalid @enderror" id="price" value="{{ old('price') }}">
                                                @error('price')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="date">Date</label>
                                                <div class="input-group date" id="chicken_datetimepicker" data-target-input="nearest">
                                                    <input type="text" name="date" class="form-control datetimepicker-input  @error('date') is-invalid @enderror"
                                                    data-target="#chicken_datetimepicker" value="{{ old('date')}}"/>
                                                    <div class="input-group-append" data-target="#chicken_datetimepicker" data-toggle="datetimepicker">
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
                                   </div>
                                   <div id="turkey" hidden>
                                       <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <label for="turkey_exampleFormControlSelect1">Breed</label>
                                                <select name="species" class="form-control" id="turkey_exampleFormControlSelect1">
                                                    <option value="Beltsville Small White">Beltsville Small White</option>
                                                    <option value="Black Turkey">Black Turkey</option>
                                                    <option value="Blue Slate">Blue Slate</option>
                                                    <option value="Bourbon Reds">Bourbon Reds</option>
                                                    <option value="Broad Breasted Whites">Broad Breasted Whites</option>
                                                    <option value="Midget White">Midget White</option>
                                                    <option value="Narragansett">Narragansett</option>
                                                    <option value="Standard Bronze">Standard Bronze</option>
                                                    <option value="White Holland">White Holland</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="turkey_pen">Pen House</label>
                                                    <select name="pen" class="form-control" id="turkey_pen">
                                                    </select>
                                                {{-- @else
                                                <input type="text" name="pen"  class="form-control @error('pen') is-invalid @enderror" id="turkey_pen" value="{{ old('pen') }}">
                                                @endif --}}
                                                @error('pen')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="turkey_number">Number of Birds</label>
                                                <input type="number" name="number" min="0" class="form-control @error('number') is-invalid @enderror" id="turkey_number" value="{{ old('number') }}">
                                                @error('number')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="turkey_price">Price per Bird</label>
                                                <input type="number" name="price" min="0" step="0.01" class="form-control @error('price') is-invalid @enderror" id="turkey_price" value="{{ old('price') }}">
                                                @error('price')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="date">Date</label>
                                                <div class="input-group date" id="turkey_datetimepicker" data-target-input="nearest">
                                                    <input type="text" name="date" class="form-control datetimepicker-input  @error('date') is-invalid @enderror"
                                                    data-target="#turkey_datetimepicker" value="{{ old('date')}}"/>
                                                    <div class="input-group-append" data-target="#turkey_datetimepicker" data-toggle="datetimepicker">
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
                                   </div>
                                   <div id="guinea_fowl" hidden>
                                       <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <label for="fowl_exampleFormControlSelect1">Breed</label>
                                                <select name="species" class="form-control" id="fowl_exampleFormControlSelect1">
                                                    <option value="White-breasted">White-breasted guineafowl</option>
                                                    <option value="Black guineafowl">Black guineafowl</option>
                                                    <option value="Helmeted guineafowl">Helmeted guineafowl</option>
                                                    <option value="Plumed guineafowl">Plumed guineafowl</option>
                                                    <option value="Crested guineafowl">Crested guineafowl</option>
                                                    <option value="Vulturine guineafowl">Vulturine guineafowl</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="fowl_pen">Pen House</label>
                                                    <select name="pen" class="form-control" id="fowl_pen">
                                                    </select>
                                                {{-- @else
                                                <input type="text" name="pen"  class="form-control @error('pen') is-invalid @enderror" id="fowl_pen" value="{{ old('pen') }}">
                                                @endif --}}
                                                @error('pen')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="fowl_number">Number of Birds</label>
                                                <input type="number" name="number" min="0" class="form-control @error('number') is-invalid @enderror" id="fowl_number" value="{{ old('number') }}">
                                                @error('number')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="price">Price per Bird</label>
                                                <input type="number" name="price" min="0" step="0.01" class="form-control @error('price') is-invalid @enderror" id="fowl_price" value="{{ old('price') }}">
                                                @error('price')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="date">Date</label>
                                                <div class="input-group date" id="fowl_datetimepicker" data-target-input="nearest">
                                                    <input type="text" name="date" class="form-control datetimepicker-input  @error('date') is-invalid @enderror"
                                                    data-target="#fowl_datetimepicker" value="{{ old('date')}}"/>
                                                    <div class="input-group-append" data-target="#fowl_datetimepicker" data-toggle="datetimepicker">
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
                                   </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" id="submitForm" class="btn btn-primary">Submit</button>
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
                                    <th>Price per Bird(GHS &#162;)</th>
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
            <hr>
            <div class="" style="display:flex; justify-content:center;align-content: space-between;">
                <div class="">
                    <ul class="pagination">
                        <li class="page-item"><a class="btn btn-primary" href="{{url('/dashboard')}}">Previous</a></li>
                        <li class="page-item"><a class="btn btn-primary" href="{{route('setup.finish')}}" class="btn btn-primary btn-sm">Next</a></li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- edit form modal --}}
        <div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="editModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalCenterTitle">Edit Bird</h5>
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
                                    <label for="edit_price">Price per Bird</label>
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
    @parent
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment-with-locales.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/js/tempusdominus-bootstrap-4.min.js"></script>
 @endsection

 @section('script')
    @parent
    let selectDOM = []
    function getPen(body){

        body = {...body,"_token":$('meta[name="csrf-token"]').attr('content')};
        {{-- console.log(JSON.stringify(body)); --}}
        return fetch('{{ route('api.pen') }}', {
            method:'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body:JSON.stringify(body),
        })
        .then(response => response.json())
        .then(data => {
            return data;
        })
        .catch((error) => {
        console.error('Error:', error);
        });
    }
    $('input:radio[name=bird]').change((e)=>{
        switch(e.target.value){
            case 'chicken':
                $('#turkey').attr('hidden',true);
                $('#guinea_fowl').attr('hidden',true)
                $('#chicken').removeAttr('hidden');
                getPen({"bird":"chicken","farm_id":"{{auth()->user()->farm_id}}"})
                .then(pen =>{
                    let select = $("#chicken_pen")
                    select.empty()
                    pen.forEach( (current,index) =>{
                        {{-- console.logconsole.log(current,index) --}}
                        select.append(`<option value="${current.pen_id}">${current.pen_id}</option>`);
                    })
                })
                break;
            case 'turkey':
                $('#chicken').attr('hidden',true);
                $('#turkey').removeAttr('hidden');
                $('#guinea_fowl').attr('hidden',true)
                getPen({"bird":"turkey","farm_id":"{{auth()->user()->farm_id}}"})
                .then(pen =>{
                    let select = $("#turkey_pen")
                    select.empty()
                    pen.forEach( (current,index) =>{
                        select.append(`<option value="${current.pen_id}">${current.pen_id}</option>`);
                    })
                })
                break;
            case 'guinea_fowl':
                $('#chicken').attr('hidden',true);
                $('#turkey').attr('hidden',true);
                $('#guinea_fowl').removeAttr('hidden')
                getPen({"bird":"guinea_fowl","farm_id":"{{auth()->user()->farm_id}}"})
                .then(pen =>{
                    let select = $("#fowl_pen")
                    select.empty()
                    pen.forEach( (current,index) =>{
                        {{-- console.log(current,index) --}}
                        select.append(`<option value="${current.pen_id}">${current.pen_id}</option>`);
                    })
                })
                break;
        }
    });
    $("#submitForm").on('click',(e)=>{
       form = document.getElementById('birdForm');
       {{-- .submit() --}}
       switch(form['bird'].value){
           case 'chicken':
                $('#turkey').remove();
                $('#guinea_fowl').remove();
                break;
           case 'turkey':
            $('#chicken').remove();
            $('#guinea_fowl').remove();
            break;
           case 'guinea_fowl':
                $('#chicken').remove();
                $('#turkey').remove();
                break;
           default:
            alert("select a bird and enter detials");
       }
       form.submit();
    })
    $('#chicken_datetimepicker,#fowl_datetimepicker,#turkey_datetimepicke,#edit_datetimepicker').datetimepicker({
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
        ajax: "{{ route('datatables.population','all') }}",
        columns: [
            {data: 'batch_id', name: 'batch_id'},
            {{-- {data: 'farm_name', name: 'farm_name'}, --}}
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
        if( bird_data.type){
            $('#edit_type').val(bird_data.type);
        }else{
            $('#edit_type').attr('disabled',true)
        }
        $('#edit_pen').val(bird_data.pen_id);
        $('#edit_number').val(bird_data.number);
        $('#edit_price').val(bird_data.unit_price);
        let date = new Date(bird_data.date);
        let dd = date.getDate() < 10 ? '0'+ date.getDate(): date.getDate();
        let mm = (date.getMonth()+1 < 10) ? '0'+(date.getMonth()+1): date.getMonth()+1;
        let yy = date.getFullYear();
        $('#edit_date').val(`${dd}/${mm}/${yy}`)
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
