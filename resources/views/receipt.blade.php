<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Money Receipt</title>

    <style>

        body{
            font-family: DejaVu Sans, sans-serif;
            background:#f3f5fa;
            padding:25px;
            color:#222;
        }

        .receipt{
            max-width:780px;
            margin:auto;
            background:#fff;
            border-radius:12px;
            border:1px solid #dfe6f3;
            overflow:hidden;
        }

        /* HEADER */

        .header{
            padding:35px 35px 20px;
        }

        .brand{
            font-size:58px;
            font-weight:700;
            color:#0d47a1;
            margin:0;
            line-height:1;
        }

        .receipt-title{
            margin-top:12px;
            font-size:24px;
            color:#666;
            letter-spacing:1px;
        }

        .receipt-title span{
            color:#0d47a1;
            margin:0 10px;
            font-weight:bold;
        }

        .receipt-info{
            text-align:right;
            font-size:15px;
            line-height:2;
        }

        .receipt-info strong{
            color:#111;
        }

        .receipt-id{
            background:#0d47a1;
            color:#fff;
            padding:6px 14px;
            border-radius:5px;
            font-weight:700;
            display:inline-block;
        }

        .top-line{
            height:3px;
            background:#0d47a1;
            margin-top:25px;
            border-radius:30px;
        }

        /* BODY */

        .content{
            padding:30px 35px;
        }

        /* BOX */

        .info-box{
            border:1px solid #d7dfed;
            border-radius:10px;
            overflow:hidden;
            background:#fff;
        }

        .student-header{
            background:#edf4ff;
            color:#0d47a1;
        }

        .payment-header{
            background:#eefaf1;
            color:#198754;
        }

        .info-header{
            padding:16px 20px;
            font-size:22px;
            font-weight:700;
        }

        .info-content{
            padding:15px 18px;
        }

        .info-row{
            padding:12px 0;
            border-bottom:1px solid #ececec;
            font-size:15px;
        }

        .info-row:last-child{
            border-bottom:none;
        }

        .label{
            width:85px;
            display:inline-block;
            font-weight:700;
        }

        /* STATUS */

        .status{
            background:#198754;
            color:#fff;
            padding:5px 12px;
            border-radius:6px;
            font-size:13px;
            font-weight:700;
        }

        /* TABLE */

        .payment-table{
            width:100%;
            border-collapse:collapse;
            margin-top:28px;
        }

        .payment-table th{
            background:#0d47a1;
            color:#fff;
            padding:14px;
            text-align:left;
            font-size:15px;
        }

        .payment-table td{
            border:1px solid #e9edf5;
            padding:14px;
            font-size:15px;
        }

        /* TOTAL */

        .total-box{
            margin-top:28px;
            border:2px solid #cfdcf3;
            border-radius:12px;
            background:#f8fbff;
            padding:22px 25px;
        }

        .total-title{
            font-size:32px;
            font-weight:700;
            color:#0d47a1;
        }

        .total-amount{
            font-size:38px;
            font-weight:700;
            color:#0d47a1;
            text-align:right;
        }

        /* FOOTER */

        .footer{
            text-align:center;
            padding:28px 20px 35px;
            color:#0d47a1;
            font-style:italic;
            font-size:26px;
        }

        .line{
            width:130px;
            height:2px;
            background:#0d47a1;
            display:inline-block;
            vertical-align:middle;
            margin:0 12px;
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

                    <h1 class="brand">B@tchPoint</h1>

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
                            👤 STUDENT INFO
                        </div>

                        <div class="info-content">

                            <div class="info-row">
                                <span class="label">Name</span>
                                :
                                {{ $payment->student?->full_name ?? 'N/A' }}
                            </div>

                            <div class="info-row">
                                <span class="label">Batch</span>
                                :
                                {{ $payment->student?->batch_name ?? 'N/A' }}
                            </div>

                            <div class="info-row">
                                <span class="label">ID</span>
                                :
                                {{ $payment->student?->student_id ?? 'N/A' }}
                            </div>

                            <div class="info-row">
                                <span class="label">Phone</span>
                                :
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
                            💳 PAYMENT INFO
                        </div>

                        <div class="info-content">

                            <div class="info-row">
                                <span class="label">Month</span>
                                :
                                {{ $payment->month ?? 'N/A' }}
                            </div>

                            <div class="info-row">
                                <span class="label">Course</span>
                                :
                                {{ $payment->student?->course_name ?? 'N/A' }}
                            </div>

                            <div class="info-row">
                                <span class="label">Method</span>
                                :
                                {{ $payment->payment_method ?? 'N/A' }}
                            </div>

                            <div class="info-row">
                                <span class="label">Status</span>
                                :

                                <span class="status">
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
                        🧾 TOTAL PAID
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
