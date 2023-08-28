<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class JobNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $candidate;
    public $jobDetails;

    public function __construct($candidate,$jobDetails)
    {
        $this->candidate = $candidate;
        $this->jobDetails = $jobDetails;
    }

    public function build()
    {
        return $this->view('emails.job_notification')
                    ->subject('New Job Application Received')->with([
                        'candidate' => $this->candidate,
                        'jobDetails' => $this->jobDetails
                    ]);
    }
}
