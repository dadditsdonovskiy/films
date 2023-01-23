<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SmtpTest extends Command
{
    /**
     * Send test email to the provided address
     *
     * @var string
     */
    protected $signature = 'smtp:test {--emailTo= : The Email on which test email should be sent}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send test email to the provided address';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $subject = 'Welcome to ' . env('APP_NAME');
        // it is better to use argument rather than an option
        $emailTo = $this->option('emailTo');
        if (empty($emailTo)) {
            $this->error("emailTo option is required");
            return;
        }

        if (in_array(config('mail.driver'), ['log', 'array'])) {
            $this->error(
                "Note that NOW email driver is set to log or array so NO real email will be sent in this case"
            );
        }

        Mail::raw(
            "Dear user,\n
To complete your registration flow, please follow the link\n
If you did not request the above email, ignore this message.
        ",
            function ($message) use ($emailTo, $subject) {
                $message->to($emailTo)->subject($subject);
            }
        );

        $this->info("Email has been successfully sent\n");
    }
}
