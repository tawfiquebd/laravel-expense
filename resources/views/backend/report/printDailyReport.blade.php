<html>
<head>
    <meta charset="utf-8">
    <title>Daily Report</title>
    <link rel="stylesheet" href="{{ asset('backend/dist/css/adminlte.css') }}">
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
            <h1 class="text-center">Report</h1>
            <hr>
        </header>

        <div class="table-style table-responsive-sm">
            <span>Date: {{ $date }}</span> <br>
            <span>Name: {{ $userDetails->name }}</span> <br>
            <span>Email: {{ $userDetails->email }}</span> <br>
            <br>

            <table class="table text-center table-striped">
                <thead>
                    <tr>
                        <th>SL.</th>
                        <th>Description</th>
                        <th>Cost (Tk)</th>
                    </tr>
                </thead>
                <tbody>
                @php
                    $i = 1;
                @endphp
                @foreach($expenses as $expense)
                    <tr>
                        <td style="width: 20%">{{ $i++ }}</td>
                        <td style="width: 40%">{{ $expense->name }}</td>
                        <td style="width: 20%">{{ $expense->cost }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <table class="balance">
            <hr>
            @foreach($totalCost as $cost)
            <tr>
                <th><span >Total</span></th>
                <td><span>{{ $cost->total }}</span></td>
            </tr>
            @endforeach
        </table>

    </div>

    <script>window.print();</script>
</body>
</html>
