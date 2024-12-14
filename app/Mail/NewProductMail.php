<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewProductMail extends Mailable
{
    use Queueable, SerializesModels;

    public $product;
    public $token;

    /**
     * Create a new message instance.
     */
    public function __construct($product, $token)
    {
        $this->product = $product;
        $this->token = $token;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('New Product Notification')
                    ->view('emails.new_product_notification');
    }
}
