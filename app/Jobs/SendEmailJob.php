<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $emailMessage;
    protected $attachments;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user, $emailMessage, $attachmentsJson)
    {
        $this->user = $user;
        $this->emailMessage = $emailMessage;
        $this->attachments = json_decode($attachmentsJson, true);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            Mail::send([], [], function ($message) {
                $message->from($this->user['program']['coordinator']['email'], $this->user['program']['coordinator']['name']);
                $message->to($this->user['interndata']['companyEmail'])->subject('PENGESAHAN PENERIMAAN PENEMPATAN LATIHAN INDUSTRI');
                $message->setBody($this->emailMessage, 'text/html');
                foreach ($this->attachments as $attachment) {
                    if (is_array($attachment)) {
                        $message->attachData($attachment['data'], $attachment['name'], $attachment['options']);
                    } else {
                        $message->attach($attachment);
                    }
                }
            });

            // Log a success message
            Log::info('Email sent successfully');
        } catch (\Exception $e) {
            // Log the exception message
            Log::error('Error sending email: ' . $e->getMessage());

            // Re-throw the exception to mark the job as failed
            throw $e;
        }
    }
}
