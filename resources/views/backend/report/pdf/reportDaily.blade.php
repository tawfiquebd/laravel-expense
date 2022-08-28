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
        <h1 style="text-align: center;">Expense Manager</h1>
        <h3 style="text-align: center;">Daily Report</h3>
    </header>

    <div class="report-body">
        <br>

        <table style="width: 70%;
                margin: 0 auto;
                text-align: left;
                border-collapse: collapse;
        ">
            {{--<tr>--}}
            {{--<th style="width: 22%;">Expense Category : </th>--}}
            {{--<td style="width: 22%;"> </td>--}}
            {{--</tr>--}}

            <tr>
                <th style="width: 32%;">Date :</th>
                <td style="width: 32%;">{{ Carbon\Carbon::parse($date)->format('d-M-Y') }}</td>
            </tr>

            <tr>
                <th style="border: 1px solid #000;">Total Cash in</th>
                <th style="border: 1px solid #000;">Total Cash out</th>
                <th style="border: 1px solid #000;">Final Balance</th>
            </tr>
            <tr>
                <th style="border: 1px solid #000;">{{ $totalDepositAmount }}</th>
                <th style="border: 1px solid #000;">{{ $totalCashOutAmount }}</th>
                <th style="border: 1px solid #000;">{{ $totalDepositAmount ? $finalAvailableBalance : $finalWholeAvailableBalance }}</th>
            </tr>
        </table>

        <table style="width: 70%;
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
            </tr>

            @php
                $i = 1;
            @endphp

            @foreach($expenses as $expense)
                <tr>
                    <td style="border: 1px solid #000;">{{ $i++ }}</td>
                    <td style="border: 1px solid #000;">{{ \Carbon\Carbon::parse($date)->format('d-M-Y') }}</td>
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
                </tr>
            @endforeach
        </table>

        <table style="width: 70%;
                margin: 0 auto;
                text-align: left;
                border-collapse: collapse;
                margin-top: 20px;
        ">
            <tr>
                <td colspan="6" style="border: 1px solid #000;">Total Available Balance</td>
                <td style="border: 1px solid #000;">{{ $totalDepositAmount ? $finalAvailableBalance : $finalWholeAvailableBalance }} TK.</td>
            </tr>
        </table>
    </div>

    <br> <br>

    <table style="width: 70%;
                margin: 0 auto;
                text-align: left;
                border-collapse: collapse;
         ">

        <tr>
            <th style="width: 50%;">System Generated Report</th>
            <th style="width: 50%;">Generated at {{ date('d-M-Y') }}</th>
        </tr>

    </table>

</div>

<script>

</script>
</body>
</html>
