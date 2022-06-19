<?php

namespace App\Listeners;

use App\Events\PostPublished;
use App\Mail\PostEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendPostNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\PostPublished  $event
     * @return void
     */
    public function handle(PostPublished $event)
    {
        $website = $event->post->website;

        $post = [
            'title' => $event->post->title,
            'body'  => $event->post->description
        ];

        foreach ($website->subscribes as $recipient)
            Mail::to($recipient->email)->queue(new PostEmail($post));
    }
}
