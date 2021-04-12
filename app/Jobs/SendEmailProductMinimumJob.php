<?php

namespace App\Jobs;

use App\Mail\MailProductMinimum;
use App\Models\{Product, User};
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailProductMinimumJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    private $product;
    private $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Product $product, User $user)
    {
        $this->product = $product;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::send(new MailProductMinimum($this->product, $this->user));
    }
}
