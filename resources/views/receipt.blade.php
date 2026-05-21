<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Money Receipt</title>

    <style>
        body{
            font-family: DejaVu Sans, sans-serif;
            background:#f5f5f5;
            padding:20px;
        }

        .receipt-box{
            background:#fff;
            border-radius:10px;
            overflow:hidden;
            border:1px solid #ddd;
        }

        .header{
            background:#1565f9;
            color:white;
            padding:30px;
        }

        .header-table{
            width:100%;
        }

        .header-left h1{
            margin:0;
            font-size:38px;
        }

        .header-left h2{
            margin-top:10px;
            font-weight:normal;
            font-size:28px;
        }

        .header-right{
            text-align:right;
            font-size:18px;
        }

        .content{
            padding:35px;
        }

        .info-table{
            width:100%;
            margin-bottom:30px;
        }

        .info-box{
            width:48%;
            border:1px solid #ddd;
            border-radius:10px;
            padding:20px;
            vertical-align:top;
        }

        .info-title{
            font-size:22px;
            font-weight:bold;
            margin-bottom:15px;
        }

        .info-box p{
            margin:10px 0;
            font-size:18px;
        }

        .badge{
            background:green;
            color:white;
            padding:4px 10px;
            border-radius:5px;
            font-size:14px;
        }

        .payment-table{
            width:100%;
            border-collapse:collapse;
            margin-top:20px;
        }

        .payment-table th{
            background:#eef1f8;
            padding:15px;
            border:1px solid #ddd;
            text-align:left;
        }

        .payment-table td{
            padding:15px;
            border:1px solid #ddd;
        }

        .total-box{
            margin-top:40px;
            background:#eef3fb;
            padding:25px;
            border-left:6px solid #1565f9;
            border-radius:8px;
        }

        .total-table{
            width:100%;
        }

        .total-left{
            font-size:32px;
        }

        .total-right{
            text-align:right;
            font-size:38px;
            color:#1565f9;
            font-weight:bold;
        }

        .signature{
            margin-top:80px;
            text-align:right;
        }

        .signature-line{
            display:inline-block;
            border-top:2px solid #000;
            padding-top:10px;
            width:250px;
            text-align:center;
            font-weight:bold;
        }
    </style>
</head>

<body>

<div class="receipt-box">

    <!-- HEADER -->
    <div class="header">

        <table class="header-table">
            <tr>
                <td class="header-left">
                    <h1>B@tchPoint</h1>
                    <h2> MONEY RECEIPT</h2>
                </td>

                <td class="header-right">
                    <strong>Receipt No: #{{ $payment->id }}</strong><br><br>
                    Date: {{ $payment->payment_date }}
                </td>
            </tr>
        </table>

    </div>

    <!-- CONTENT -->
    <div class="content">

        <!-- INFO -->
        <table class="info-table">
            <tr>

                <td class="info-box">
                    <div class="info-title">Student Information</div>

                    <p><strong>Name:</strong> {{ $payment->student->full_name }}</p>
                    <p><strong>Name:</strong> {{ $payment->student->batch_name }}</p>
                    <p><strong>Student ID:</strong>
                        {{ $payment->student->student_id }}
                    </p>

                    <p><strong>Phone:</strong>
                        {{ $payment->student->phone }}
                    </p>
                </td>

                <td width="4%"></td>

                <td class="info-box">
                    <div class="info-title">Payment Information</div>

                    <p><strong>Month:</strong>
                        {{ $payment->month }}
                    </p>

                    <p><strong>Course:</strong>
                        {{ $payment->student->course_name }}
                    </p>
                    <p><strong>Payment Method:</strong>
                        {{ $payment->payment_method }}
                    </p>
                    <p>
                        <strong>Status:</strong>
                        <span class="badge">
                            {{ ucfirst($payment->status) }}
                        </span>
                    </p>
                </td>

            </tr>
        </table>

        <!-- TABLE -->
        <table class="payment-table">

            <thead>
                <tr>
                    <th>#</th>
                    <th>Description</th>
                    <th width="180">Amount</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td>1</td>
                    <td>Monthly Coaching Fee</td>
                    <td>{{ $payment->amount }}</td>
                </tr>

                <tr>
                    <td>2</td>
                    <td>Paid Amount</td>
                    <td> {{ $payment->paid_amount }}</td>
                </tr>
            </tbody>

        </table>

        <!-- TOTAL -->
        <div class="total-box">

            <table class="total-table">
                <tr>
                    <td class="total-left">
                        Total Paid
                    </td>

                    <td class="total-right">
                        {{ $payment->paid_amount }}
                    </td>
                </tr>
            </table>

        </div>


    </div>
</div>

</body>
</html>
