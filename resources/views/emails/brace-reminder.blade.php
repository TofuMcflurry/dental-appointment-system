<!DOCTYPE html>
<html>
<head>
    <title>Brace Adjustment Reminder</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #f8f9fa; padding: 20px; text-align: center; }
        .content { padding: 20px; }
        .footer { background: #f8f9fa; padding: 20px; text-align: center; font-size: 14px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>🦷 Brace Adjustment Reminder</h2>
        </div>
        
        <div class="content">
            <p>Hello {{ $patient->name }},</p>
            
            <p>This is a friendly reminder that your brace adjustment is in 
            <strong>{{ $daysUntilAdjustment }} days</strong>.</p>
            
            <p><strong>Appointment Details:</strong></p>
            <ul>
                <li>Adjustment Date: {{ \Carbon\Carbon::parse($reminder->scheduled_at)->format('F j, Y') }}</li>
                <li>Reminder Type: 
                    @if($reminder->type == '7days_before')
                        <strong>7 Days Before Appointment</strong>
                    @elseif($reminder->type == '3days_before')
                        <strong>3 Days Before Appointment</strong>
                    @elseif($reminder->type == 'day_of')
                        <strong>Day of Appointment</strong>
                    @else
                        {{ $reminder->type }}
                    @endif
                </li>
            </ul>
            
            <p>Please make sure to attend your appointment on time.</p>
        </div>
        
        <div class="footer">
            <p>Best regards,<br><strong>Dental Clinic Team</strong></p>
        </div>
    </div>
</body>
</html>