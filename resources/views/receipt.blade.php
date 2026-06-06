<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Money Receipt</title>

    <style>

        body{
            font-family: DejaVu Sans, sans-serif;
            background:#f3f5fa;
            padding:10px;
            color:#222;
        }

        .receipt{
            max-width:700px;
            margin:auto;
            background:#fff;
            border:1px solid #dfe6f3;
            border-radius:8px;
            overflow:hidden;
        }

        /* HEADER */

        .header{
            padding:18px 22px 12px;
        }

        .brand{
            font-size:34px;
            font-weight:700;
            color:#0d47a1;
            margin:0;
            line-height:1;
        }

        .receipt-title{
            margin-top:6px;
            font-size:16px;
            color:#666;
        }

        .receipt-title span{
            color:#0d47a1;
            font-weight:bold;
            margin:0 6px;
        }

        .receipt-info{
            text-align:right;
            font-size:12px;
            line-height:1.8;
        }

        .receipt-id{
            background:#0d47a1;
            color:#fff;
            padding:4px 10px;
            border-radius:4px;
            font-weight:700;
            display:inline-block;
        }

        .top-line{
            height:2px;
            background:#0d47a1;
            margin-top:12px;
        }

        /* CONTENT */

        .content{
            padding:16px 22px 20px;
        }

        /* INFO BOX */

        .info-box{
            border:1px solid #dbe3f0;
            border-radius:7px;
            overflow:hidden;
            background:#fff;
        }

        .info-header{
            padding:10px 14px;
            font-size:15px;
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
            padding:10px 14px;
        }

        .info-row{
            padding:7px 0;
            border-bottom:1px solid #eee;
            font-size:12px;
        }

        .info-row:last-child{
            border-bottom:none;
        }

        .label{
            width:55px;
            display:inline-block;
            font-weight:700;
        }

        /* STATUS */

        .status{
            background:#198754;
            color:#fff;
            padding:2px 7px;
            border-radius:4px;
            font-size:10px;
            font-weight:700;
        }

        /* TABLE */

        .payment-table{
            width:100%;
            border-collapse:collapse;
            margin-top:18px;
        }

        .payment-table th{
            background:#0d47a1;
            color:#fff;
            padding:9px;
            text-align:left;
            font-size:12px;
        }

        .payment-table td{
            border:1px solid #eceff5;
            padding:9px;
            font-size:12px;
        }

        /* TOTAL */

        .total-box{
            margin-top:18px;
            border:1px solid #cfdcf3;
            border-radius:8px;
            background:#f8fbff;
            padding:14px 18px;
        }

        .total-title{
            font-size:18px;
            font-weight:700;
            color:#0d47a1;
        }

        .total-amount{
            font-size:22px;
            font-weight:700;
            color:#0d47a1;
            text-align:right;
        }

        /* FOOTER */

        .footer{
            text-align:center;
            padding:14px 10px 18px;
            color:#0d47a1;
            font-style:italic;
            font-size:14px;
        }

        .line{
            width:70px;
            height:1px;
            background:#0d47a1;
            display:inline-block;
            vertical-align:middle;
            margin:0 8px;
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

                    <h1 class="brand">Betikkrom </h1>

                    <div class="receipt-title">
                        <span>—</span>
                        Money Receipt
                        <span>—</span>
                    </div>

                </td>

                <td class="receipt-info">

                    <strong>Receipt No:</strong>

                    <span class="receipt-id">
                        #{{ $payment->id }}
                    </span>

                    <br>

                    <strong>Date:</strong>

                    {{ $payment->payment_date ?? 'N/A' }}

                </td>

            </tr>
        </table>

        <div class="top-line"></div>

    </div>

    <!-- CONTENT -->

    <div class="content">

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

                                <span class="status">
                                    {{ ucfirst($payment->status ?? 'N/A') }}
                                </span>

                            </div>

                        </div>

                    </div>

                </td>

            </tr>
        </table>

        <!-- TABLE -->

        <table class="payment-table">

            <thead>
                <tr>
                    <th width="10%">#</th>
                    <th>Description</th>
                    <th width="28%">Amount</th>
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
