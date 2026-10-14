<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Booking Confirmation</title>
    <style>
        /* બેઝિક સ્ટાઈલ જે બધા ઈમેલ ક્લાયન્ટમાં ચાલે */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f7f6;
            color: #333;
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        /* heade */
        .header {
            background: #ffffff;
            padding: 25px 20px;
            text-align: center;
            border-bottom: 2px solid #e0e0e0;
        }

        .header img {
            max-width: 120px;
            height: auto;
            margin-bottom: 10px;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #2c3e50;
            font-weight: 700;
        }

        .header p {
            margin: 5px 0 0;
            font-size: 14px;
            color: #7f8c8d;
        }

        /* main content */
        .content {
            padding: 30px;
            line-height: 1.6;
        }

        .welcome-text {
            font-size: 18px;
            color: #27ae60;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .thank-you {
            font-size: 16px;
            margin-bottom: 25px;
            color: #555;
        }

        /* details table */
        .details-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-top: 10px;
            border: 1px solid #eaeaea;
            border-radius: 8px;
            background-color: #fbfbfb;
        }

        .details-table td {
            padding: 15px;
            border-bottom: 1px solid #eaeaea;
            font-size: 15px;
        }

        .details-table tr:last-child td {
            border-bottom: none;
        }

        .details-table td.label {
            font-weight: 600;
            color: #7f8c8d;
            width: 40%;
        }

        .details-table td.value {
            color: #2c3e50;
            font-weight: 500;
            text-align: right;
        }

        .status-badge {
            background-color: #d4edda;
            color: #155724;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
        }

        /* */
        .button-container {
            text-align: center;
            margin-top: 30px;
        }

        .button {
            background-color: #27ae60;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            font-size: 16px;
        }

        /* ફૂટર */
        .footer {
            background: #f9f9f9;
            padding: 20px;
            text-align: center;
            border-top: 1px solid #e0e0e0;
        }

        .footer p {
            margin: 5px 0;
            font-size: 12px;
            color: #95a5a6;
        }

        .footer .support-link {
            color: #3498db;
            text-decoration: none;
            font-weight: 500;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            {{-- લોગો એમ્બેડ કરવા માટે $message->embed વાપરો --}}
            @if(file_exists(public_path('photos/llm.png')))
                <img src="{{ $message->embed(public_path('photos/llm.png')) }}" alt="Ganesh PGMS Logo">
            @endif
            <h1>My Home PGMS</h1>
            <p>Your Reliable Hosting Partner</p>
        </div>

        <div class="content">
            <p class="welcome-text">Hello {{ $details['name'] }},</p>
            <p class="thank-you">We are thrilled to confirm that your payment was successful and your room booking is
                now finalized. Welcome to the Ganesh PG family!</p>

            <h3 style="color: #2c3e50; margin-bottom: 15px;">Your Booking Summary</h3>

            <table class="details-table">
                <tr>
                    <td class="label">Room Number:</td>
                    <td class="value"><strong>{{ $details['room_no'] }}</strong></td>
                </tr>
                <tr>
                    <td class="label">Book Date:</td>
                    <td class="value">{{ $details['book_date'] }}</td>
                </tr>
                <tr>
                    <td class="label">Leave Date:</td>
                    <td class="value">{{ $details['leave_date'] }}</td>
                </tr>
                <tr>
                    <td class="label">Amount Paid:</td>
                    <td class="value" style="font-size: 18px; color: #27ae60;">
                        ₹{{ number_format($details['amount'], 2) }}</td>
                </tr>
                <tr>
                    <td class="label">Payment Status:</td>
                    <td class="value"><span class="status-badge">Active & Confirmed</span></td>
                </tr>
            </table>

            <p style="margin-top: 25px; color: #555;">Please keep this email for your records. If you have any
                questions, feel free to contact our support team.</p>
        </div>

        <div class="footer">
            <p>My Home PGMS | Raj complex, Gurukul Road, Memnagar</p>
            <!-- <p>Need Help? <a href="mailto:support@ganeshpg.com" class="support-link">support@ganeshpg.com</a></p> -->
            <p style="font-size: 11px; margin-top: 15px;">This is an automated confirmation email. Please do not reply
                directly.</p>
        </div>
    </div>
</body>

</html>