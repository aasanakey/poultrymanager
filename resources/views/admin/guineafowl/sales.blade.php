@extends('admin.guineafowl.dashboard')
@section('styles')
    @parent
     <style>
          @media print{
            footer,.no-print{
                display:none;
            }
             .card{
                width: 100vw !important;
            }
            #salesBarChart{
                widows: 100% !important;
            }
        }
        #msg {
            /* font-size: 88px; */
            font-weight: normal;
            letter-spacing: 4px;
            text-transform: uppercase;
            text-align:center;
            color: #ff0000;
            position: fixed;
            top: 40%;
            left: 10%;
            z-index: 5;
            animation-name: bounce;
            animation-duration: 2s;
            animation-iteration-count: infinite;
        }
        @keyframes bounce {
            0% {
                transform: translateY(0px);
                color: #ff4c00;
            }
            40% {
                transform: translateY(-40px);
                color:#ff4c1d;
            }

            80%{ color: #ff001d;}
            100% {
                transform: translateY(0px);
                color: ##ff0000;
            }
        }
    </style>
@endsection
@section('dash_content')
<div class="">
    <div class="row mt-4 no-print">
        <a href="{{route('admin.sale.bird','guinea_fowl')}}" class="btn btn-sm btn-primary" style="margin-left:5px;margin-right:5px;">Add Bird Sale</a>
        <a href="{{route('admin.sale.meat','guinea_fowl')}}" class="btn btn-sm btn-primary" style="margin-left:5px;margin-right:5px;">Add Meat Sale</a>
        <a href="{{route('admin.sale.egg','guinea_fowl')}}" class="btn btn-sm btn-primary" style="margin-left:5px;margin-right:5px;">Add Egg Sale</a>
        <button type="button" class="btn btn-sm" title="print" onclick="window.print()"><i class="fas fa-print" aria-hidden="true"></i></i></button>
    </div>
     <div class="row mt-5">
          <h5 id="msg" class="col-md-12 no-print">Loading data ...</h5>
          <h2 class="col-md-12" style="text-align:center;">Sales for <span id="heading-year"></span></h2>
        <div class="col-lg-6">
            <div class="card mb-4">
                <div class="card-header"><i class="fas fa-chart-bar mr-1"></i>Sales</div>
                 <select class="custom-select custom-select-sm no-print" style="width:100px;" id="years" name="year"></select>
                <div class="card-body"><canvas id="salesBarChart" width="100%" height="50"></canvas></div>
                <div class="card-footer small text-muted">Currency : Ghana Cedis &#162;</div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card mb-4">
                <div class="card-header"><i class="fas fa-chart-pie mr-1"></i>Sales Break Down</div>
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Amount</th>
                            {{-- <th>Meat</th>
                            <th>Egg</th> --}}
                    </thead>
                    <tbody id="salesTable">
                        <tr class="">
                            <td>Birds</td>
                            <td class="bs_total"></td>
                        </tr>
                        <tr class="">
                            <td>Meat</td>
                            <td class="ms_total"></td>
                        </tr>
                        <tr class="">
                            <td>Eggs</td>
                            <td class="es_total"></td>
                        </tr>
                        <tr>
                            <td>Total</td>
                            <td class="total"></td>
                        </tr>
                    </tbody>
                </table>
                <div class="card-footer small text-muted">Currency : Ghana Cedis &#162;</div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script-tags')
    @parent
     <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
     {{-- <script src="{{ asset('/js/create_chart.js')}}"></script> --}}
@endsection
@section('script')
    @parent
    createDropdown();
    var ctx = document.getElementById("salesBarChart");
    var salesChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [],
            datasets: []
            ,
        },
        options: {
            scales: {
            xAxes: [{
                time: {
                unit: 'month'
                },
                gridLines: {
                display: false
                },
                ticks: {
                maxTicksLimit: 6
                }
            }],
            yAxes: [{
                ticks: {
                min: 0,
                max: 10,
                maxTicksLimit: 5,
                },
                gridLines: {
                display: true
                }
            }],
            },
            legend: {
                display: true
            }
        }
    });
   let y = new Date().getFullYear();
   loadSales(y);
    $("#heading-year").html(y);
    $('#years').change(e=>{
        let year = e.target.value;
        salesChart.clear();
        $('#msg').removeAttr('hidden');
        $("#heading-year").html(year);
        loadSales(year);
    });
    function createDropdown(){
        var max = new Date().getFullYear(),
        min = max - 5,
        select = $('#years');

        for (var i = min; i<=max; i++){
            if(i == max){
                select.append(`<option selected value="${i}">${i}</option>`);
            }else{
                select.append(`<option value="${i}">${i}</option>`);
            }
        }
    }

    function loadSales(y){
          $.ajax({
            method:"GET",
            url:"{{ route('sales.all','guinea_fowl')}}",
            "Content-Type":"application/json",
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}",
            },
            data: {
                    year: y,
                    type:"guinea_fowl",
                    _token: "{{ csrf_token()}}",
                },
            success: (res)=>{
            let colors = {
                    BirdSale:{
                        backgroundColor: "rgba(2,117,216,1)",
                        borderColor: "rgba(2,117,216,1)"
                    },
                    MeatSale:{
                        backgroundColor: "rgba(2,117,216,0.5)",
                        borderColor: "rgba(120,117,216,1)",
                    },
                    EggSale:{
                        backgroundColor: "rgba(117,120,216,0.8)",
                        borderColor: "rgba(2,117,216,0.5)"
                    }
                }


                table_data = {
                    BirdSale:0,
                    MeatSale:0,
                    EggSale:0,
                };
                labels = [];
                datasets = []
                for( let key of Object.keys(res)){
                    for (let i = 0; i < res[key].length; i++) {
                        let obj = res[key][i];
                    {{-- updating chart --}}
                    labels = [...labels,...obj.months].unique();
                    {{-- table_data = { ...obj.months} --}}
                    datasets.push({
                            label: key,
                            backgroundColor: colors[key].backgroundColor,
                            borderColor: colors[key].borderColor,
                            data: [ ...obj.sales],
                        });
                        {{-- calculating sales total --}}
                        for(k = 0; k < res[key][i].sales.length; k++){
                            table_data[key] += obj.sales[k];
                        }

                    }

                    salesChart.options.scales.yAxes[0].ticks.max =   res.final_max
                    $('.bs_total').html(table_data.BirdSale.toFixed(2));
                    $('.ms_total').html(table_data.MeatSale.toFixed(2));
                    $('.es_total').html(table_data.EggSale.toFixed(2));
                    $('.total').html((table_data.BirdSale+table_data.MeatSale+table_data.EggSale).toFixed(2))
                }
                salesChart.data.labels = labels;
                 salesChart.data.datasets = datasets
                $('#msg').attr('hidden',true);
                salesChart.update();

            },
            error: (error)=>{
                console.log(error);
            }
        });
    };
    @endsection
