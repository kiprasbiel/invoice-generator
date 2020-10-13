<?php


namespace App\Http\services\pdf;


use App\Models\Invoice;
use App\Models\Meta;

class PdfGenerator
{
    private $invoice;
    private $invoiceMeta;

    public function __construct(Invoice $invoice, Meta $invoiceMeta)
    {
        $this->invoice = $invoice;
        $this->invoiceMeta = json_decode($invoiceMeta->value);
    }

    public function downloadPdf($view = 'pdf.invoice')
    {
        $html = view($view, ['invoiceData' => $this->invoice, 'invoiceMeta' => $this->invoiceMeta])->render();
        $mpdf = new \Mpdf\Mpdf([
            'tempDir' => storage_path() . '/temp',
        ]);

        $stylesheet = file_get_contents('css/pdf.css');

        $mpdf->WriteHTML($stylesheet, \Mpdf\HTMLParserMode::HEADER_CSS);
        $mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);

        return response()->streamDownload(function () use ($mpdf) {
            $mpdf->Output();
        }, 'test.pdf');
    }
}
