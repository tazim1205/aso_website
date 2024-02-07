<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class CustomerPriceIncrease extends Notification
{
    use Queueable;

    public $customerBid;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($customerBid)
    {
        $this->customerBid = $customerBid;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'message' => $this->customerBid->workerGig->title,
            'title' => 'Budget Updated- '.$this->customerBid->customer->full_name,
            'url' => url(route('worker.showCustomerBid', \Illuminate\Support\Facades\Crypt::encryptString($this->customerBid->id))),
        ];
    }
}
