<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
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
    public function __construct($user, $emailMessage, $attachments)
    {
        $this->user = $user;
        $this->emailMessage = $emailMessage;
        $this->attachments = $attachments;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::send([], [], function ($message) {
            $message->from($this->user->program->coordinator->email, $this->user->program->coordinator->name);
            $message->to($this->user->interndata->companyEmail)->subject('PENGESAHAN PENERIMAAN PENEMPATAN LATIHAN INDUSTRI');
            $message->setBody($this->emailMessage, 'text/html');
            foreach ($this->attachments as $attachment) {
                if (is_array($attachment)) {
                    $message->attachData($attachment['data'], $attachment['name'], $attachment['options']);
                } else {
                    $message->attach($attachment);
                }
            }
        });
    }
}
