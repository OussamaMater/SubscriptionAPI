<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\User;
use App\Mail\SubsEmail;
use App\Models\Website;
use App\Models\SendEmailLog;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;


class SendEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:send {--force}';

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
        $forced   = $this->option('force');
        $executed = SendEmailLog::where('created_at', '>=', Carbon::now()->subDay())->count();

        if ($forced || ($executed == 0)) {
            SendEmailLog::create();
            $usersCount = DB::table('subscribes')->select()->count();

            $this->info('Sending emails...');
            $bar = $this->output->createProgressBar($usersCount);
            $bar->start();

            $websites = Website::with('subscribes')->get();
            foreach ($websites as $website) {
                foreach ($website->subscribes as $recipient) {
                    Mail::to($recipient->email)->queue(new SubsEmail($recipient->name));
                    $bar->advance();
                }
            }

            $bar->finish();
            $this->info("\n" . 'done!');
        } else {
            $this->error('Can\'t send emails now...');
        }
    }
}
