<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Application Update</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; background-color: #f9fafb; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: #fff; padding: 30px; border-radius: 8px; border: 1px solid #e5e7eb; }
        .header { border-bottom: 2px solid #eff6ff; padding-bottom: 20px; margin-bottom: 20px; }
        .status-badge { display: inline-block; padding: 6px 12px; border-radius: 4px; font-weight: bold; text-transform: uppercase; font-size: 14px; }
        .status-selected { background: #dcfce7; color: #166534; }
        .status-rejected { background: #fee2e2; color: #991b1b; }
        .btn { display: inline-block; background: #2563eb; color: #fff; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-weight: bold; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2 style="color: #2563eb; margin: 0;">CareerConnect</h2>
        </div>
        
        <p>Dear {{ optional($application->user)->name }},</p>
        
        <p>We are writing to inform you of an update regarding your recent application for the <strong>{{ optional($application->job)->title }}</strong> position at <strong>{{ optional(optional($application->job)->company)->name ?? 'our organization' }}</strong>.</p>
        
        <p>Your current application status has been marked as:</p>
        
        @if($application->status === 'selected')
            <p><span class="status-badge status-selected">Selected 🎉</span></p>
            <p>Congratulations! The recruiting team was very impressed with your profile and resume. The hiring manager or HR department will be reaching out to your email shortly with next steps regarding the interview or onboarding process.</p>
        @else
            <p><span class="status-badge status-rejected">Not Selected</span></p>
            <p>Thank you for expressing interest in our team. Unfortunately, we have decided to move forward with other candidates who more closely match our requirements at this time. We sincerely appreciate the time you took to build your profile and apply.</p>
        @endif

        <a href="{{ url('/my-applications') }}" class="btn">View Application Dashboard</a>
        
        <p style="margin-top: 40px; font-size: 12px; color: #9ca3af;">
            This is an automated notification from the CareerConnect Applicant Tracking System.
        </p>
    </div>
</body>
</html>
