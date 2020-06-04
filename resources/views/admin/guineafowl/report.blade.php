@extends('admin.chicken.dashboard')
@section('styles')
    @parent
@endsection
@section('dash_content')
<div class="">
     <div class="row">
        <div class="col-lg-6">
            <div class="card mb-4">
                <div class="card-header"><i class="fas fa-chart-bar mr-1"></i>Sales</div>
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
                max: 100,
                maxTicksLimit: 5,
                 {{-- callback: function(value, index, values) {
                        return 'GHS ' + value;
                    } --}}
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

    $.ajax({
        method:"GET",
        url:"{{ route('sales.all','guinea_fowl')}}",
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
            for( let key of Object.keys(res)){
                {{-- console.log(key,colors[key]); --}}
                for (let i = 0; i < res[key].length; i++) {
                   let obj = res[key][i];
                   {{-- updating chart --}}
                   salesChart.data.labels = [ ...obj.months]
                   {{-- table_data = { ...obj.months} --}}
                   salesChart.data.datasets.push({
                        label: key,
                        backgroundColor: colors[key].backgroundColor,
                        borderColor: colors[key].borderColor,
                        data: [ ...obj.sales],
                    });
                    {{-- calculating sales total --}}
                    table_data[key] += obj.sales[i];
                }
                salesChart.options.scales.yAxes[0].ticks.max =   res.final_max
                $('.bs_total').html(table_data.BirdSale.toFixed(2));
                $('.ms_total').html(table_data.MeatSale.toFixed(2));
                $('.es_total').html(table_data.EggSale.toFixed(2));
                $('.total').html((table_data.BirdSale+table_data.MeatSale+table_data.EggSale).toFixed(2))
            }

            console.log(table_data);
            salesChart.update();

        },
        error: (error)=>{
            console.log(error);
        }
    });
    @endsection
