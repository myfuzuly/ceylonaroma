<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class OrderStatusMail extends Mailable
{
    use SerializesModels;

    public function __construct(public Order $order) {}

    public function envelope(): Envelope
    {
        $label = match($this->order->status) {
            'confirmed'  => 'Order Confirmed',
            'processing' => 'Order Being Processed',
            'shipped'    => 'Your Order Has Been Shipped',
            'delivered'  => 'Order Delivered',
            'cancelled'  => 'Order Cancelled',
            default      => 'Order Update',
        };
        return new Envelope(subject: "{$label} — Ceylon Aroma #{$this->order->order_number}");
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.order-status',
            with: [
                'trackUrl' => URL::signedRoute('order.confirmation', ['orderNumber' => $this->order->order_number]),
            ],
        );
    }
}
