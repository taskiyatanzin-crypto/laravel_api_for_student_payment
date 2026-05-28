<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Money Receipt</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            background: #f5f7fb;
            padding: 20px;
            color: #333;
        }

        .receipt {
            max-width: 750px;
            margin: auto;
            background: #fff;
            border: 1px solid #e5e5e5;
        }

        /* HEADER */
        .header {
            background: #1565f9;
            color: #fff;
            padding: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 28px;
        }

        .header h2 {
            margin: 5px 0 0;
            font-size: 18px;
            font-weight: normal;
        }

        .header-info {
            text-align: right;
            font-size: 14px;
        }

        /* CONTENT */
        .content {
            padding: 20px;
        }

        .row {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
        }

        .box {
            flex: 1;
            border: 1px solid #eee;
            padding: 15px;
            margin:left;
        }

        .title {
            font-weight: bold;
            margin-bottom: 10px;
            font-size: 16px;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
        }

        p {
            margin: 6px 0;
            font-size: 14px;
        }

        /* TABLE */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #eee;
            padding: 10px;
            font-size: 14px;
        }

        th {
            background: #f3f6ff;
            text-align: left;
        }

        /* TOTAL */
        .total {
            margin-top: 20px;
            padding: 15px;
            background: #f3f6ff;
            border-left: 4px solid #1565f9;
            display: flex;
            justify-content: space-between;
            font-size: 18px;
            font-weight: bold;
        }

        .badge {
            background: #16a34a;
            color: #fff;
            padding: 2px 8px;
            font-size: 12px;
            border-radius: 4px;
        }
    </style>
</head>

<body>

<div class="receipt">

    <!-- HEADER -->
    <div class="header">
        <table width="100%">
            <tr>
                <td>
                    <h1>B@tchPoint</h1>
                    <h2>Money Receipt</h2>
                </td>

                <td class="header-info">
                    Receipt No: #{{ $payment->id }} <br>
                    Date: {{ $payment->payment_date ?? 'N/A' }}
                </td>
            </tr>
        </table>
    </div>

    <!-- CONTENT -->
    <div class="content">

        <!-- INFO ROW -->
        <div class="row">

            <div class="box">
                <div class="title">Student Info</div>

                <p>Name: {{ $payment->student?->full_name ?? 'N/A' }}</p>
                <p>Batch: {{ $payment->student?->batch_name ?? 'N/A' }}</p>
                <p>ID: {{ $payment->student?->student_id ?? 'N/A' }}</p>
                <p>Phone: {{ $payment->student?->phone ?? 'N/A' }}</p>
            </div>

            <div class="box">
                <div class="title">Payment Info</div>

                <p>Month: {{ $payment->month ?? 'N/A' }}</p>
                <p>Course: {{ $payment->student?->course_name ?? 'N/A' }}</p>
                <p>Method: {{ $payment->payment_method ?? 'N/A' }}</p>

                <p>
                    Status:
                    <span class="badge">
                        {{ ucfirst($payment->status ?? 'N/A') }}
                    </span>
                </p>
            </div>

        </div>

        <!-- TABLE -->
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Description</th>
                    <th>Amount</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td>1</td>
                    <td>Monthly Coaching Fee</td>
                    <td>৳ {{ $payment->amount ?? 0 }}</td>
                </tr>

                <tr>
                    <td>2</td>
                    <td>Paid Amount</td>
                    <td>৳ {{ $payment->paid_amount ?? 0 }}</td>
                </tr>
            </tbody>
        </table>

        <!-- TOTAL -->
        <div class="total">
            <span>Total Paid</span>
            <span>৳ {{ $payment->paid_amount ?? 0 }}</span>
        </div>

    </div>

</div>

</body>
</html>
