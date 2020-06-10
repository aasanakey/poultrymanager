@extends('admin.guineafowl.dashboard')

@section('dash_content')
<div class="container mt-4">
    <div>
        <select class="custom-select custom-select-sm" id="years" style="width:100px;" name="year"></select>
    </div>
    <h3>Income</h3>
    <table class="table table-condensed pl-table" id="income_table">
        <tbody></tbody>
        <tfoot class="summary">
            <tr>
                <th class="text-right">Total Revenue:</th>
                <th class="text-right text-success" id="total_income">&#162; 0.00</th>
            </tr>
        </tfoot>
    </table>

    <h3>Expenses</h3>
    <table class="table table-condensed pl-table" id="expense_table">
        <tbody>
        </tbody>
        <tfoot class="summary">
            <tr>
                <th class="text-right">Total Expenses:</th>
                <th class="text-right text-danger" id="total_expense">&#162; 0.00</th>
            </tr>
            <tr id="profit">
                <th class="text-right">Profit:</th>
                <th class="text-right text-success">&#162; 0.00</th>
            </tr>
        </tfoot>
    </table>

</div>
@endsection

@section('script')
    @parent
    createDropdown();
    getSatatement(new Date().getFullYear());
    $('#years').change(e=>{
        getSatatement(e.target.value);
    });
    function getSatatement(year){
        $.ajax({
            method:"GET",
            url:"{{route('statement.all')}}",
            "Content-Type":"application/json",
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}",
            },
            data: {
                    year: year,
                    type:"guinea_fowl",
                    _token: "{{ csrf_token()}}",
            },
            success:(res)=>{
                    console.log(res);
                    let expense = displayExpenses(res.expense);
                    let income = displayIncome(res.income);
                    let profit = income - expense;
                    if( profit < 0){
                        $('#profit').html(
                            `<th class="text-right">Loss:</th>
                             <th class="text-right text-danger">&#162; ${Math.abs(profit).toFixed(2)}</th>`
                            );
                    }else if( profit > 0){
                        $('#profit').html(
                            `<th class="text-right">Profit:</th>
                            <th class="text-right text-success">&#162; ${profit.toFixed(2)}</th>`
                            );
                    }else{
                        $('#profit').html(
                            `<th class="text-right">Profit:</th>
                            <th class="text-right text-dark">&#162; ${profit.toFixed(2)}</th>`
                            );
                    }

            },
            error: (error)=>{
                console.log(error);
            }

        });
    }

    {{-- show income --}}
    function displayIncome(income){
        $('#income_table tbody').html('');
        let total_income = 0
        {{-- console.log(income); --}}
        for( let key of Object.keys(income)){
            for (i = 0; i < income[key].length; i++){
                let obj = income[key][i].income;
                {{-- console.log(key, obj) --}}
                if(key == "Transaction"){
                     obj.forEach((v,i)=>{
                        for(let k=0; k < v.length; k++){
                            console.log(v[k])
                            if(v[k] != 0){
                                v[k].income = parseFloat(v[k].income);
                                $("#income_table tbody").append(
                                `<tr>
                                    <td>
                                        ${v[k].description}
                                    </td>
                                    <td class="text-right">
                                    &#162; ${v[k].income.toFixed(2)}
                                    </td>
                                </tr>`
                                );
                                total_income +=v[k].income;
                            }
                        }
                    });
                }else{
                    obj.forEach((v,i)=>{
                        for(let k=0; k < v.length; k++){
                            if(v[k] != 0){
                                v[k] = parseFloat(v[k]);
                                $("#income_table tbody").append(
                                `<tr>
                                    <td>
                                        Sale of ${key}
                                    </td>
                                    <td class="text-right">
                                    &#162; ${v[k].toFixed(2)}
                                    </td>
                                </tr>`
                                );
                                total_income +=v[k];
                            }
                        }
                    });
                }
            }
        }

         $('#total_income').html(`&#162; ${total_income.toFixed(2)}`);
        return total_income
    }
{{-- show expenses --}}
function displayExpenses(expenses){
    $('#expense_table tbody').html('');
    let total_expense = 0;
    for( let key of Object.keys(expenses)){
        for (i = 0; i < expenses[key].length; i++){
            let obj = expenses[key][i].expense;
            {{-- console.log(key, typeof obj,$.isArray(obj)) --}}
            if(key === "Transaction"){
                obj.forEach((value,index)=>{
                    if($.isArray(value)){
                        value.forEach((val,i)=>{
                            let ammount = parseFloat(val.expense);
                            $('#expense_table tbody').append(
                                `<tr>
                                    <td>
                                        ${val.description}
                                    </td>
                                    <td class="text-right">
                                    &#162; ${ammount.toFixed(2)}
                                    </td>
                                </tr>`
                            );
                            total_expense += ammount;
                        });
                    }
                });
            }else{
                obj.forEach((value,index)=>{
                    {{-- console.log(value); --}}
                    for (i = 0; i < value.length; i++){
                        if( value[i] != 0){
                            $('#expense_table tbody').append(
                                `<tr>
                                    <td>
                                        Purchase of ${key}
                                    </td>
                                    <td class="text-right">
                                    &#162; ${value[i].toFixed(2)}
                                    </td>
                                </tr>`
                            );
                            total_expense += value[i];
                        }
                    }
                })
            }
        }
    }
    $('#total_expense').html(`&#162; ${total_expense.toFixed(2)}`);
    return total_expense;
}
{{--  create a dynamic dropdown of last 5 years--}}
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
@endsection
