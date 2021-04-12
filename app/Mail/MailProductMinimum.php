<?php

namespace App\Mail;

use App\Models\{Product, User};
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailProductMinimum extends Mailable
{
    use Queueable, SerializesModels;

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
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->subject('Lara Product');
        $this->to($this->user->email, $this->user->name);
        return $this->view('mail.product-minimum',['product' => $this->product]);  
    }
}
