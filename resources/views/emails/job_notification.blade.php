<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>New Job Application Received</title>
</head>
<body>
    <p>New job application has been submitted for the {{ $jobDetails->job_title }} at {{ $jobDetails->company }}.</p>

    <h4>Candidate Details:</h4>
    <p>Name: {{ $candidate['name'] }}</p>
    <p>Email: {{ $candidate['email'] }}</p>
    <p>Phone: {{ $candidate['phone'] }}</p>
</body>
</html>