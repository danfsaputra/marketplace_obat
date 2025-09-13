<?php
namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderInvoiceMail extends Mailable
{
    use Queueable, SerializesModels;
    public $order;
    protected $pdfData;

    public function __construct($order, $pdfData)
    {
        $this->order = $order;
        $this->pdfData = $pdfData;
    }

    public function build()
    {
        return $this->subject("Invoice Order {$this->order->order_number}")
                    ->view('emails.order_invoice')
                    ->attachData($this->pdfData, "invoice-{$this->order->order_number}.pdf", [
                        'mime' => 'application/pdf',
                    ]);
    }
}
