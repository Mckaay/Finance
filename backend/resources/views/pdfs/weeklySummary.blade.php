<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        h4 {
            margin: 0;
        }

        .w-full {
            width: 100%;
        }

        .w-half {
            width: 50%;
        }

        .margin-top {
            margin-top: 1.25rem;
        }

        .footer {
            font-size: 0.875rem;
            padding: 1rem;
            background-color: rgb(241 245 249);
        }

        table {
            width: 100%;
            border-spacing: 0;
        }

        table.transactions {
            font-size: 0.875rem;
        }

        table.transactions tr {
            background-color: rgb(96 165 250);
        }

        table.transactions th {
            color: #ffffff;
            padding: 0.5rem;
        }

        table tr.items {
            background-color: rgb(241 245 249);
        }

        table tr.items td {
            padding: 0.5rem;
        }

        .amount,
        .date {
            text-align: center;
        }
    </style>
    <title>Summary</title>
</head>
<body>
<div class="margin-top">
    <table class="w-full">
        <tr>
            <td class="w-half">
                <div><h4>From:</h4></div>
                <div>Finance</div>
            </td>
        </tr>
    </table>
</div>

<div class="margin-top">
    <table class="transactions">
        <tr>
            <th>Recipient / Sender</th>
            <th>Transaction Date</th>
            <th>Amount</th>
        </tr>
        @foreach($transactions as $transaction)
            <tr class="items">
                <td>
                    {{ $transaction['name'] }}
                </td>
                <td class="date">
                    {{ $transaction['date'] }}
                </td>
                <td class="amount">
                    ${{ $transaction['amount'] }}
                </td>
            </tr>
        @endforeach
    </table>
</div>

<div class="footer margin-top">
    <div>Thank you</div>
    <div>&copy; Finance</div>
</div>
</body>
</html>
