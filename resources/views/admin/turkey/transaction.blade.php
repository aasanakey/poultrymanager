@extends('admin.turkey.dashboard')
@section('styles')
    @parent
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/css/tempusdominus-bootstrap-4.min.css" />
@endsection
@section('dash_content')
<div class="container mt-4">
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Transaction</li>
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
                        Record Transaction
                    </button>
                </span>
                <span>
                    <a href="{{route('export.transactions','turkey')}}"  class="btn btn-sm btn-primary ml-2">Export Data</a>
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
                        <form id="mortalityForm" method="POST" action="{{ route('admin.add.transaction','turkey')}}">
                            @csrf
                            <div class="form-row">
                                <div class="col-md-4">
                                    <label for="">Type</label>
                                </div>
                                <div class="form-check form-check-inline" style="margin-right:55px;">
                                    <input class="form-check-input @error('type') is-invalid @enderror" type="radio" name="type" id="expense" value="expense" {{ old('type')? 'checked' : 'checked'}}>
                                    <label class="form-check-label" for="expense">Expense</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input @error('type') is-invalid @enderror" type="radio" name="type" id="income" value="income" {{ old('type')? 'checked' : ''}}>
                                    <label class="form-check-label" for="income">Income</label>
                                </div>
                                 @error('type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="date">Transaction Date</label>
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
                                <div class="form-group col-md-6">
                                    <label for="amount">Amount (GHS &#162;) </label>
                                    <input type="number" name="amount" min="0" step="0.01" placeholder="0.00" class="form-control  @error('amount') is-invalid @enderror" value="{{ old('amount')}}"/>
                                        @error('amount')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="category">Category</label>
                                    <input type="text" name="category" id="category" placeholder="eg rent,insurance" class="form-control  @error('category') is-invalid @enderror" value="{{ old('category')}}"/>
                                        @error('category')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                </div>
                                <div class="form-group col-md-6" >
                                        <label  for="account" id="account-label">Account Name</label>
                                        <input class="form-control @error('account') is-invalid @enderror" id="account"
                                        type="text"  name="account" value="{{ old('account') }}" placeholder="eg Darko Farms"/>

                                    @error('account')
                                        <span id="farm_contact_error" class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="description">Description</label>
                                    <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" cols="30" rows="5">{{ old('description')}}</textarea>
                                    @error('description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <input type="text" name="farm_category" value="turkey" hidden>
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
                            <th>Type</th>
                            <th>Date</th>
                            <th>Amount (GHS &#162;)</th>
                            <th>Category</th>
                            <th>Account Name</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                           <th>Type</th>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Category</th>
                            <th>Account Name</th>
                            <th>Description</th>
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
    $('input:radio[name=type]').change((e)=>{
        label = $('#account-label');
        switch(e.target.value){
            case 'income':
                label.html("Customer")
                break
            case 'expense':
                label.html("Payee")
                break;
        }
    });
    $('#datetimepicker1,#hire_date_datetimepicker1').datetimepicker({
        'format':'L',
        icons: {
        time: "fa fa-clock",
        date: "fa fa-calendar",
        up: "fa fa-arrow-up",
        down: "fa fa-arrow-down"
    }});
    $('#dataTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('datatables.transactions','turkey') }}",
        columns: [
            {data:"type", name:"type"},
            {data:"date", name:"date"},
            {data:"amount", name:"amount"},
            {data:"category", name:"category"},
            {data:"account", name:"account"},
            {data:"description", name:"description"},
            {data: 'action', name: 'Action', orderable: false, searchable: false},
        ]
    });
@endsection

