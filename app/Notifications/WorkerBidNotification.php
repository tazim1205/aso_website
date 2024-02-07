<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class WorkerBidNotification extends Notification
{
    use Queueable;

    public $workerBid;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($workerBid)
    {
        $this->workerBid = $workerBid;
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
            'message' => $this->workerBid->customerGig->title,
            'title' => 'New bid by- '.$this->workerBid->worker->full_name,
            'url' => url(route('customer.showCustomerGig', \Illuminate\Support\Facades\Crypt::encryptString($this->workerBid->customerGig->id))),
        ];
    }
}
