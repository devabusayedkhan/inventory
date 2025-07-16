<html>

<head>
    <style>
        body {
            background: #fff;
        }

        h2 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        table th,
        table td {
            border: 1px solid #ddd;
            padding: 5px;
            text-align: left;
            font-size: 12px;
        }

        table th {
            background-color: #12a05c;
            color: #fff;
        }

        .summary-section,
        .details-section {
            margin-bottom: 30px;
        }

        .summary-table td {
            font-weight: bold;
        }

        .text-bold {
            font-weight: bold;
        }

        .green-header {
            background-color: #12a05c;
            color: white;
        }

        .details-table td {
            font-size: 14px;
        }
    </style>
</head>

<body>

    <h2>Summary</h2>
    <table class="summary-table">
        <thead>
            <tr class="green-header">
                <th>Report</th>
                <th>Date</th>
                <th>Total</th>
                <th>Discount</th>
                <th>Vat</th>
                <th>Payable</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Sales Report</td>
                <td>{{$formDate}} to {{$toDate}}</td>
                <td>{{$total}}</td>
                <td>{{$discount}}</td>
                <td>{{$vat}}</td>
                <td>{{$payable}}</td>
            </tr>
        </tbody>
    </table>

    <h2>Details</h2>
    <table class="details-table">
        <thead>
            <tr class="green-header">
                <th>Customer</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Total</th>
                <th>Discount</th>
                <th>Vat</th>
                <th>Payable</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($list as $item)
                <tr>
                    <td>{{$item->customer->name}}</td>
                    <td>{{$item->customer->mobile}}</td>
                    <td>{{$item->customer->email}}</td>
                    <td>{{$item->total}}</td>
                    <td>{{$item->discount}}</td>
                    <td>{{$item->vat}}</td>
                    <td>{{$item->payable}}</td>
                    <td>{{$item->created_at}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>