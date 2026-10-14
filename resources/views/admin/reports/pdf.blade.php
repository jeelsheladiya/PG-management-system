<!DOCTYPE html>
<html>

<head>
    <title>Management Report</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        body {
            font-family: "DejaVu Sans", sans-serif;
            color: #333;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #4e73df;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .title {
            color: #4e73df;
            margin: 0;
            text-transform: uppercase;
        }

        .stats-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .stats-table th,
        .stats-table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        .stats-table th {
            background-color: #f8f9fa;
            color: #4e73df;
        }

        .footer {
            margin-top: 30px;
            font-size: 12px;
            text-align: center;
            color: #777;
        }

        .summary-box {
            background: #f4f7fe;
            padding: 15px;
            border-radius: 8px;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1 class="title">My Home PG - Management Report</h1>
        <p>Generated on: {{ $reportDate }}</p>
    </div>

    <h3>1. Occupancy Overview</h3>
    <table class="stats-table">
        <tr>
            <th>Total Beds</th>
            <td>{{ $totalBeds }}</td>
        </tr>
        <tr>
            <th>Occupied Beds</th>
            <td>{{ $occupiedBeds }} ({{ $occupancyPercent }}%)</td>
        </tr>
        <tr>
            <th>Vacant Beds</th>
            <td>{{ $vacantBeds }}</td>
        </tr>
    </table>

    <h3>2. Financial Summary</h3>
    <table class="stats-table">
        <tr>
            <th>Total Revenue (Paid)</th>
            <td>₹{{ number_format($totalPayments, 2) }}</td>
        </tr>
        <tr>
            <th>Pending Dues</th>
            <td style="color: red;">₹{{ number_format($pendingPayments, 2) }}</td>
        </tr>
    </table>

    <h3>3. Operational Alerts</h3>
    <table class="stats-table">
        <tr>
            <th>Total Registered Members</th>
            <td>{{ $totalMembers }}</td>
        </tr>
        <tr>
            <th>Unresolved Complaints</th>
            <td>{{ $openComplaints }}</td>
        </tr>
    </table>

    <div class="summary-box">
        <strong>System Insight:</strong> Currently, the PG is running at <b>{{ $occupancyPercent }}%</b> capacity.
        There are <b>{{ $openComplaints }}</b> issues that need immediate attention.
    </div>

    <div class="footer">
        <p>This is a system-generated report for My Home PG Management.</p>
    </div>
</body>

</html>