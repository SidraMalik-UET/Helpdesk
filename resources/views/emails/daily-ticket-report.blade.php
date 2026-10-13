
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Ticket Report</title>
</head>

<body style="margin:0; padding:0; background-color:#f1f5f9; font-family:Arial, Helvetica, sans-serif; color:#1e293b;">

    <table width="100%" cellpadding="0" cellspacing="0" role="presentation"
           style="background-color:#f1f5f9; padding:30px 10px;">
        <tr>
            <td align="center">

                <table width="600" cellpadding="0" cellspacing="0" role="presentation"
                       style="width:100%; max-width:600px; background:#ffffff; border-radius:12px; overflow:hidden;">

                    <!-- Header -->
                    <tr>
                        <td style="background:#172554; padding:30px; color:#ffffff;">
                            <p style="margin:0 0 8px; font-size:12px; letter-spacing:2px; color:#bfdbfe;">
                                SMART HELPDESK
                            </p>
                            <h1 style="margin:0; font-size:25px;">
                                Daily Ticket Report
                            </h1>
                            <p style="margin:10px 0 0; font-size:14px; color:#dbeafe;">
                                Your daily support operations summary
                            </p>
                        </td>
                    </tr>

                    <!-- Report Date -->
                    <tr>
                        <td style="padding:25px 25px 10px;">
                            <p style="margin:0; font-size:14px; color:#64748b;">
                                REPORT DATE
                            </p>
                            <h2 style="margin:6px 0 0; font-size:20px;">
                                {{ \Carbon\Carbon::parse($report['date'])->format('F j, Y') }}
                            </h2>
                        </td>
                    </tr>

                    <!-- Statistics -->
                    <tr>
                        <td style="padding:15px;">
                            <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                <tr>
                                    <td width="50%" style="padding:8px;">
                                        <table width="100%" cellpadding="0" cellspacing="0" role="presentation"
                                               style="background:#eff6ff; border:1px solid #bfdbfe; border-radius:8px;">
                                            <tr>
                                                <td style="padding:20px;">
                                                    <p style="margin:0; color:#1d4ed8; font-size:13px;">
                                                        Tickets Opened
                                                    </p>
                                                    <h2 style="margin:12px 0 0; font-size:32px; color:#1e40af;">
                                                        {{ $report['opened'] }}
                                                    </h2>
                                                    <p style="margin:6px 0 0; font-size:12px; color:#64748b;">
                                                        Created today
                                                    </p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>

                                    <td width="50%" style="padding:8px;">
                                        <table width="100%" cellpadding="0" cellspacing="0" role="presentation"
                                               style="background:#f0fdf4; border:1px solid #bbf7d0; border-radius:8px;">
                                            <tr>
                                                <td style="padding:20px;">
                                                    <p style="margin:0; color:#15803d; font-size:13px;">
                                                        Tickets Resolved
                                                    </p>
                                                    <h2 style="margin:12px 0 0; font-size:32px; color:#166534;">
                                                        {{ $report['resolved'] }}
                                                    </h2>
                                                    <p style="margin:6px 0 0; font-size:12px; color:#64748b;">
                                                        Resolved today
                                                    </p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>

                                <tr>
                                    <td width="50%" style="padding:8px;">
                                        <table width="100%" cellpadding="0" cellspacing="0" role="presentation"
                                               style="background:#fff7ed; border:1px solid #fed7aa; border-radius:8px;">
                                            <tr>
                                                <td style="padding:20px;">
                                                    <p style="margin:0; color:#c2410c; font-size:13px;">
                                                        Overdue Tickets
                                                    </p>
                                                    <h2 style="margin:12px 0 0; font-size:32px; color:#9a3412;">
                                                        {{ $report['overdue'] }}
                                                    </h2>
                                                    <p style="margin:6px 0 0; font-size:12px; color:#64748b;">
                                                        Require attention
                                                    </p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>

                                    <td width="50%" style="padding:8px;">
                                        <table width="100%" cellpadding="0" cellspacing="0" role="presentation"
                                               style="background:#f5f3ff; border:1px solid #ddd6fe; border-radius:8px;">
                                            <tr>
                                                <td style="padding:20px;">
                                                    <p style="margin:0; color:#6d28d9; font-size:13px;">
                                                        Avg. First Response
                                                    </p>
                                                    <h2 style="margin:12px 0 0; font-size:32px; color:#5b21b6;">
                                                        {{ $report['average_response_minutes'] }}
                                                    </h2>
                                                    <p style="margin:6px 0 0; font-size:12px; color:#64748b;">
                                                        Minutes
                                                    </p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Summary -->
                    <tr>
                        <td style="padding:15px 25px 25px;">
                            <h3 style="margin:0 0 10px; font-size:17px;">
                                Daily Summary
                            </h3>
                            <p style="margin:0; font-size:14px; line-height:1.7; color:#475569;">
                                Your Smart Helpdesk daily report is ready. Review the ticket
                                activity above and prioritize overdue tickets to maintain
                                timely customer support.
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td align="center"
                            style="background:#f8fafc; border-top:1px solid #e2e8f0; padding:20px;">
                            <p style="margin:0; font-size:12px; color:#64748b;">
                                This is an automated report from Smart Helpdesk 2.0.
                            </p>
                            <p style="margin:8px 0 0; font-size:12px; color:#94a3b8;">
                                Please do not reply to this email.
                            </p>
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>
</html>
