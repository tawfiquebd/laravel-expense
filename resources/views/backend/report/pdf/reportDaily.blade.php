<html>
<head>
    <meta charset="utf-8">
    <title>Daily Report</title>
    <style>

        table.balance {
            float: right;
            width: 20%;
        }

        table.balance:after {
            clear: both;
            content: "";
            display: table;
        }
    </style>
</head>
<body>

<div class="container">
    <header>
        <br>
        <h1 style="text-align: center;">Daily Report</h1>
    </header>

    <div class="report-body">
        <br>

        <table style="width: 60%;
                margin: 0 auto;
                text-align: left;
                border-collapse: collapse;
        ">
            <tr>
                <th style="width: 22%;">Expense Category :</th>
                <td style="width: 22%;">{{ $datas['date'] }}</td>
            </tr>

            <tr>
                <td style="width: 22%;">{{ $datas['date'] }}</td>
            </tr>

            <tr>
                <th style="border: 1px solid #000;">Opening Balance</th>
                <th style="border: 1px solid #000;">Total Cash in</th>
                <th style="border: 1px solid #000;">Total Cash out</th>
                <th style="border: 1px solid #000;">Final Balance</th>
            </tr>
            <tr>
                <th style="border: 1px solid #000;">{{ 00 }}</th>
                <th style="border: 1px solid #000;">{{ $datas['totalDepositAmount'] }}</th>
                <th style="border: 1px solid #000;">{{ $datas['totalCashOutAmount'] }}</th>
                <th style="border: 1px solid #000;">{{ $datas['finalAvailableBalance'] }}</th>
            </tr>
        </table>

        <table style="width: 60%;
                margin: 0 auto;
                text-align: left;
                border-collapse: collapse;
                margin-top: 20px;
        ">

            <tr>
                <th style="border: 1px solid #000;">Sl.</th>
                <th style="border: 1px solid #000;">Date</th>
                <th style="border: 1px solid #000;">Expense Name</th>
                <th style="border: 1px solid #000;">Expense Type</th>
                <th style="border: 1px solid #000;">Deposit</th>
                <th style="border: 1px solid #000;">Withdraw</th>
                <th style="border: 1px solid #000;">Balance</th>
            </tr>

            @php
                $i = 1;
            @endphp

            @foreach($datas['expenses'] as $expense)
                <tr>
                    <td style="border: 1px solid #000;">{{ $i++ }}</td>
                    <td style="border: 1px solid #000;">{{ \Carbon\Carbon::parse($datas['date'])->format('d-M-Y') }}</td>
                    <td style="border: 1px solid #000;">{{ ucfirst($expense->name) }}</td>
                    <td style="border: 1px solid #000;">{{ ucfirst($expense->expense_type) }}</td>
                    @if ($expense->expense_type == "deposit")
                        <td style="border: 1px solid #000;">{{ $expense->cost }}</td>
                    @else
                        <td style="border: 1px solid #000;"></td>
                    @endif

                    @if ($expense->expense_type == "withdraw")
                        <td style="border: 1px solid #000;">{{ $expense->cost }}</td>
                    @else
                        <td style="border: 1px solid #000;"></td>
                    @endif
                    <td style="border: 1px solid #000;"></td>
                </tr>
            @endforeach
        </table>
    </div>

    <table class="balance">
        {{--@foreach($totalCost as $cost)--}}
        {{--<tr>--}}
        {{--<th><span >Total</span></th>--}}
        {{--<td><span>{{ $cost->total }}</span></td>--}}
        {{--</tr>--}}
        {{--@endforeach--}}
    </table>

</div>

<script>

</script>
</body>
</html>
