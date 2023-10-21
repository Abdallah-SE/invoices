<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

use Illuminate\Support\Facades\Auth;

use App\Models\invoices;

class InvoiceAlert extends Notification
{
    use Queueable;
    
    private $latest_invoice;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(invoices $_latest_invoice)
    {
        $this->latest_invoice = $_latest_invoice;
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

    public function toDatabase($notifiable)
    {
        return [
             'id'=> $this->latest_invoice->id,
            'title'=>'تم اضافة فاتورة جديد بواسطة :',
            'user'=> Auth::user()->name,
        ];
    }
    
}
