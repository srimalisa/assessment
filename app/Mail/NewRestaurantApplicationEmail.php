<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewRestaurantApplicationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $manager;
    public $restaurant;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($manager, $restaurant)
    {
        $this->manager = $manager;
        $this->restaurant = $restaurant;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $manager = $this->manager;
        $restaurant = $this->restaurant;
        $recipient_address = $manager['email'];
        $recipient_name = $manager['name'];
        $recipient_email = $manager['email'];

        $subject = 'Reminder: New Confirmation for Restaurant';

        $message = '

        <p>Assalamualaikum wbt. &amp; Greetings.</p>

        <p>Dear Sir/Madam/Mr/Ms.</p>

        <p>This is a friendly reminder that the application (Restaurant ID #'.$restaurant['id'].') '.$restaurant['name'].' has not been confirmed yet.

        Kindly update the status.</p>

        <p>Thank you for your prompt attention to this matter.</p>

        <p style="font-size: 10px;"><em>This is an automated email. Please do not reply.</em></p>
        ';

        return $this->replyTo('admin@gmail.com', 'admin')
                    ->from($recipient_email)
                    ->subject($subject)
                    ->html($message);
    }
}
