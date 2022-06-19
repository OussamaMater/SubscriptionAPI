<?php

namespace App\Console\Commands;

use App\Mail\SubsEmail;
use App\Models\Website;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;


class SendEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send an email to all subscribers';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Sending emails...');

        $websites = Website::all();
        foreach ($websites as $website) {
            foreach ($website->subscribes as $recipient)
                Mail::to($recipient->email)->queue(new SubsEmail($recipient->name));
        }

        $this->info('done!');
    }
}
