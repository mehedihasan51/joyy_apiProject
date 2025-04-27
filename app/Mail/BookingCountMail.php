<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class BookingCountMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */



    public $bookingCount;
    public function __construct()
    {
        $this->bookingCount = Booking::count(); // Pass the count
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Booking Successfully Created')
            ->html("
                <h1>Booking Completed!</h1>
                <p>Total number of bookings: {$this->bookingCount}</p>
            ");
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Booking Successfully Created',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.booking_count',
            with: [
                 // Example data, replace with actual booking count
            ],
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
