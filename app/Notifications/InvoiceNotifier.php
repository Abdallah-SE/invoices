<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InvoiceNotifier extends Notification
{
    use Queueable;
    
    private $invoice_id;


    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($_invoice_id)
    {
        $this->invoice_id = $_invoice_id;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = 'http://localhost:8000/InvoicesDetails/' . $this->invoice_id;
        /*return (new MailMessage)
                    ->subject('تنبيه بعملية اضافه جديده لفاتوره اخري')
                    ->action('عرض الفاتوره الجديده', url($url))
                    ->line('Thank you for using our application!');*/
        
        return (new MailMessage)
                ->greeting('Hello!')
                ->from('barrett@example.com', 'Barrett Blair')
                ->line('One of your invoices has been paid!')
                ->action('View Invoice', $url)
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
            //
        ];
    }
}
