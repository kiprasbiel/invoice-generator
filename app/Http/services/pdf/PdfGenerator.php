<?php


namespace App\Http\services\pdf;


use App\Models\Invoice;
use App\Models\Meta;

class PdfGenerator
{
    private $invoice;
    private $invoiceMeta;
    private $activityInfo;

    // TODO: issimti visa json decodinima i modeli
    public function __construct(Invoice $invoice, Meta $invoiceMeta)
    {
        // TODO: Padaryti tikrinima, jei del kazkokios priezasties neegzistuotu Meta  ar Activity info
        $this->invoice = $invoice;
        $this->invoiceMeta = json_decode($invoiceMeta->value);
        if (!$invoice->user->getActivitySettings()) throw new \Exception("Users activity settings don't exist.");

        $this->activityInfo = json_decode($invoice->user->getActivitySettings()->value);
    }

    public function downloadPdf($view = 'pdf.invoice')
    {
        $html = view($view, ['invoiceData' => $this->invoice, 'invoiceMeta' => $this->invoiceMeta, 'activitySettings' => $this->activityInfo])->render();
        $mpdf = new \Mpdf\Mpdf([
            'tempDir' => storage_path() . '/temp',
        ]);

        $stylesheet = file_get_contents(public_path('css/pdf.css'));

        $mpdf->WriteHTML($stylesheet, \Mpdf\HTMLParserMode::HEADER_CSS);
        $mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);

        return response()->streamDownload(function () use ($mpdf) {
            $mpdf->Output();
        }, 'test.pdf');
    }
}
