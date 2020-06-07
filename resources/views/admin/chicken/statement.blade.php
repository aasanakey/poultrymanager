@extends('admin.chicken.dashboard')

@section('dash_content')
<div class="container mt-4">
    <h3>Income</h3>
    <table class="table table-condensed pl-table">

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
    <table class="table table-condensed pl-table">
            <tr>
                <td>
                    32. Other expenses
                </td>
                <td class="text-right">
                $20.80
                </td>
            </tr>

        <tfoot class="summary">
            <tr>
            <th class="text-right">Total Expenses:</th>
            <th class="text-right">$20.80</th>
        </tr>
        <tr>
            <th class="text-right">Profit:</th>
            <th class="text-right text-success">$479.20</th>
        </tr>
        </tfoot>
    </table>

</div>
@endsection
