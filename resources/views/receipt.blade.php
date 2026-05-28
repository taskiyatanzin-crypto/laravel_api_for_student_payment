<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Money Receipt</title>

    <style>
        body{
            font-family: DejaVu Sans, sans-serif;
            background:#f4f6fb;
            padding:20px;
            color:#333;
        }

        .receipt-container{
            max-width:750px;
            margin:auto;
            background:#fff;
            border-radius:12px;
            border:1px solid #dbe3f0;
            overflow:hidden;
        }

        /* HEADER */
        .receipt-header{
            padding:25px 30px 15px;
        }

        .brand{
            font-size:42px;
            font-weight:700;
            color:#0d47a1;
            margin:0;
            line-height:1;
        }

        .receipt-title{
            font-size:20px;
            color:#666;
            margin-top:10px;
        }

        .receipt-top-line{
            height:3px;
            background:#0d47a1;
            margin-top:20px;
            border-radius:20px;
        }

        .receipt-info{
            text-align:right;
            font-size:14px;
            line-height:1.9;
        }

        .receipt-info strong{
            color:#111;
        }

        /* BODY */
        .receipt-body{
            padding:25px 30px 30px;
        }

        /* INFO BOX */
        .info-box{
            border:1px solid #dbe3f0;
            border-radius:10px;
            overflow:hidden;
            margin-bottom:20px;
        }

        .info-header{
            padding:12px 18px;
            font-size:18px;
            font-weight:700;
        }

        .student-header{
            background:#edf4ff;
            color:#0d47a1;
        }

        .payment-header{
            background:#eefbf1;
            color:#198754;
        }

        .info-content{
            padding:18px;
        }

        .info-row{
            padding:8px 0;
            border-bottom:1px solid #eee;
            font-size:14px;
        }

        .info-row:last-child{
            border-bottom:none;
        }

        .label{
            font-weight:700;
            width:90px;
            display:inline-block;
        }

        /* TABLE */
        .payment-table{
            width:100%;
            border-collapse:collapse;
            margin-top:10px;
        }

        .payment-table th{
            background:#0d47a1;
            color:#fff;
            padding:12px;
            font-size:14px;
            text-align:left;
        }

        .payment-table td{
            padding:12px;
            border:1px solid #eee;
            font-size:14px;
        }

        /* TOTAL */
        .total-box{
            margin-top:25px;
            border:2px solid #dbe3f0;
            border-radius:12px;
            padding:18px 22px;
            background:#f8fbff;
        }

        .total-title{
            font-size:26px;
            font-weight:700;
            color:#0d47a1;
        }

        .total-amount{
            font-size:30px;
            font-weight:700;
            color:#0d47a1;
            text-align:right;
        }

        /* STATUS */
        .status-badge{
            background:#198754;
            color:#fff;
            padding:4px 10px;
            border-radius:5px;
            font-size:12px;
            font-weight:700;
        }

        /* FOOTER */
        .footer{
            text-align:center;
            padding:25px;
            color:#0d47a1;
            font-style:italic;
            font-size:20px;
        }

        .line{
            width:120px;
            height:1px;
            background:#0d47a1;
            display:inline-block;
            vertical-align:middle;
            margin:0 10px;
        }

    </style>
</head>

<body>

<div class="receipt-container">

    <!-- HEADER -->
    <div class="receipt-header">

        <table width="100%">
            <tr>

                <td>
                    <h1 class="brand">B@tchPoint</h1>

                    <div class="receipt-title">
                        Money Receipt
                    </div>
                </td>

                <td class="receipt-info">
                    <strong>Receipt No:</strong>
                    #{{ $payment->id }}

                    <br>

                    <strong>Date:</strong>
                    {{ $payment->payment_date ?? 'N/A' }}
                </td>

            </tr>
        </table>

        <div class="receipt-top-line"></div>

    </div>

    <!-- BODY -->
    <div class="receipt-body">

        <!-- INFO SECTION -->
        <table width="100%">
            <tr>

                <!-- STUDENT INFO -->
                <td width="49%" valign="top">

                    <div class="info-box">

                        <div class="info-header student-header">
                            STUDENT INFO
                        </div>

                        <div class="info-content">

                            <div class="info-row">
                                <span class="label">Name</span>
                                {{ $payment->student?->full_name ?? 'N/A' }}
                            </div>

                            <div class="info-row">
                                <span class="label">Batch</span>
                                {{ $payment->student?->batch_name ?? 'N/A' }}
                            </div>

                            <div class="info-row">
                                <span class="label">ID</span>
                                {{ $payment->student?->student_id ?? 'N/A' }}
                            </div>

                            <div class="info-row">
                                <span class="label">Phone</span>
                                {{ $payment->student?->phone ?? 'N/A' }}
                            </div>

                        </div>

                    </div>

                </td>

                <td width="2%"></td>

                <!-- PAYMENT INFO -->
                <td width="49%" valign="top">

                    <div class="info-box">

                        <div class="info-header payment-header">
                            PAYMENT INFO
                        </div>

                        <div class="info-content">

                            <div class="info-row">
                                <span class="label">Month</span>
                                {{ $payment->month ?? 'N/A' }}
                            </div>

                            <div class="info-row">
                                <span class="label">Course</span>
                                {{ $payment->student?->course_name ?? 'N/A' }}
                            </div>

                            <div class="info-row">
                                <span class="label">Method</span>
                                {{ $payment->payment_method ?? 'N/A' }}
                            </div>

                            <div class="info-row">
                                <span class="label">Status</span>

                                <span class="status-badge">
                                    {{ ucfirst($payment->status ?? 'N/A') }}
                                </span>
                            </div>

                        </div>

                    </div>

                </td>

            </tr>
        </table>

        <!-- PAYMENT TABLE -->
        <table class="payment-table">

            <thead>
                <tr>
                    <th width="10%">#</th>
                    <th>Description</th>
                    <th width="25%">Amount</th>
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
        <div class="total-box">

            <table width="100%">
                <tr>

                    <td class="total-title">
                        TOTAL PAID
                    </td>

                    <td class="total-amount">
                        ৳ {{ $payment->paid_amount ?? 0 }}
                    </td>

                </tr>
            </table>

        </div>

    </div>

    <!-- FOOTER -->
    <div class="footer">

        <span class="line"></span>

        Thank you for your payment

        <span class="line"></span>

    </div>

</div>

</body>
</html>
