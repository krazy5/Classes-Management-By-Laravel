<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Receipt {{ $receipt_no }}</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; color: #333; font-size: 12px; }
        .container { width: 100%; margin: 0 auto; padding: 20px; }
        .header, .footer { text-align: center; }
        .header h1 { margin: 0; font-size: 24px; }
        .header p { margin: 5px 0; }
        .details-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .details-table th, .details-table td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        .details-table th { background-color: #f2f2f2; }
        .summary-table { width: 50%; border-collapse: collapse; margin-top: 20px; float: right; }
        .summary-table td { padding: 8px; }
        .text-right { text-align: right; }
        .logo { max-width: 150px; max-height: 75px; }
        .clearfix::after { content: ""; clear: both; display: table; }
    </style>
</head>
<body>
    <div class="container">
        <table style="width: 100%; border: 0;">
            <tr>
                <td style="width: 20%;">
                    {{-- Logo: Ensure the path is correct or use base64 encoding for reliability --}}
                    @if(file_exists($institute_logo))
                        <img src="{{ $institute_logo }}" alt="logo" class="logo">
                    @endif
                </td>
                <td style="width: 80%;" class="text-right">
                    <h1>{{ $institute_name }}</h1>
                    <p>{{ $institute_address }}</p>
                </td>
            </tr>
        </table>

        <hr>

        <h2 style="text-align: center; margin-bottom: 25px;">FEE RECEIPT</h2>

        <table style="width: 100%; margin-bottom: 20px;">
            <tr>
                <td>
                    <strong>Student Name:</strong> {{ $student->first_name }} {{ $student->last_name }}<br>
                    <strong>Student ID:</strong> {{ $student->student_id }}<br>
                    <strong>Course/Batch:</strong> {{ $student->batch_name ?? 'N/A' }}
                </td>
                <td class="text-right">
                    <strong>Receipt No:</strong> {{ $receipt_no }}<br>
                    <strong>Issue Date:</strong> {{ $issue_date }}<br>
                    <strong>Payment Date:</strong> {{ \Carbon\Carbon::parse($installment->receive_date)->format('d M, Y') }}
                </td>
            </tr>
        </table>
        
        <table class="details-table">
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Payment Mode</th>
                    <th class="text-right">Amount Paid</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Payment for Installment #{{ $installment->installment_no }}</td>
                    <td>{{ $installment->payment_mode ?? 'N/A' }}</td>
                    <td class="text-right">₹{{ number_format($installment->amount, 2) }}</td>
                </tr>
            </tbody>
        </table>

        <div class="clearfix" style="margin-top: 30px;">
             <table class="summary-table">
                <tr>
                    <td><strong>Total Fee:</strong></td>
                    <td class="text-right">₹{{ number_format($feesRecord->total_fees, 2) }}</td>
                </tr>
                 <tr>
                    <td><strong>Total Paid:</strong></td>
                    <td class="text-right">₹{{ number_format($feesRecord->received_fees, 2) }}</td>
                </tr>
                <tr style="background-color: #f2f2f2; font-weight: bold;">
                    <td><strong>Balance Due:</strong></td>
                    <td class="text-right">₹{{ number_format($feesRecord->balance_fees, 2) }}</td>
                </tr>
            </table>
        </div>

        <div class="footer" style="position: fixed; bottom: 50px; width:100%; text-align:center;">
            <p>This is a computer-generated receipt and does not require a signature.</p>
        </div>
    </div>
</body>
</html>