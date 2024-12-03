<?php

namespace App\Mail;

use App\Models\Medicine;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class LowStockAlert extends Mailable
{
    use Queueable, SerializesModels;

    public $medicine;

    public function __construct(Medicine $medicine)
    {
        $this->medicine = $medicine;
    }

    public function build()
    {
        return $this->with([
                        'id' => $this->medicine->id,
                        'brand_name' => $this->medicine->brand_name,
                        'generic_name' => $this->medicine->generic_name,
                        'quantity' => $this->medicine->quantity,
                    ]);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('flores.geraldivan@gmail.com', 'Medicine Inventory'),
            subject: 'Low Stock Alert',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.low_stock',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
