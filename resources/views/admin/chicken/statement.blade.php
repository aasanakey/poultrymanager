@extends('admin.chicken.dashboard')

@section('dash_content')
<div class="container mt-4">
    <div>
        <select class="custom-select custom-select-sm" id="years" style="width:100px;" name="year"></select>
    </div>
    <h3>Income</h3>
    <table class="table table-condensed pl-table" id="income_table">

            <tr>
                <td>
                    1a. Sales of livestock and other resale items
                </td>
                <td class="text-right">
                $500.00
                </td>
            </tr>

        <tfoot class="summary">
            <tr>
                <th class="text-right">Total Revenue:</th>
                <th class="text-right">$500.00</th>
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
            <tr>
                <th class="text-right">Profit:</th>
                <th class="text-right text-success">$479.20</th>
            </tr>
        </tfoot>
    </table>

</div>
@endsection

@section('script')
    @parent
    createDropdown();
    loadExpense(new Date().getFullYear())
    $('#years').change(e=>{
        loadExpense(e.target.value);
    });
    function loadExpense(year){
        $.ajax({
            method:"GET",
            url:"{{route('statement.all')}}",
            "Content-Type":"application/json",
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}",
            },
            data: {
                    year: year,
                    type:"chicken",
                    _token: "{{ csrf_token()}}",
            },
            success:(res)=>{
                    {{-- console.log(res); --}}
                    {{-- clear table content --}}
                    $('#expense_table tbody').html('');
                    let total_expense = 0;
                    for( let key of Object.keys(res)){
                        for (i = 0; i < res[key].length; i++){
                            let obj = res[key][i].expense;
                            console.log(key,obj)
                            if(key === "Transaction"){
                                obj.forEach((value,index)=>{
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
            },
            error: (error)=>{
                console.log(error);
            }

        });
    }
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
