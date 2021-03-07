<?php


namespace App\Http\services\pdf;


use App\Models\Invoice;
use App\Models\Item;
use App\Models\Meta;
use Illuminate\Database\Eloquent\Collection;
use Mpdf\HTMLParserMode;
use Mpdf\Mpdf;

class PdfGenerator
{
    private $invoice;
    private $items;
    private $activityInfo;

    // TODO: issimti visa json decodinima i modeli
    public function __construct(Invoice $invoice, Collection $items) {
        $this->invoice = $invoice;
        $this->items = $items;
        $this->activityInfo = json_decode($invoice->user->getUserSettings('userActivitySettings')->value);
    }

    public function downloadPdf($view = 'pdf.invoice') {
        $html = view($view, ['invoice' => $this->invoice, 'items' => $this->items, 'activitySettings' => $this->activityInfo])->render();
        $mpdf = new Mpdf([
            'tempDir' => storage_path() . '/temp',
        ]);

        $stylesheet = file_get_contents(public_path('css/pdf.css'));

        $mpdf->WriteHTML($stylesheet, HTMLParserMode::HEADER_CSS);
        $mpdf->WriteHTML($html, HTMLParserMode::HTML_BODY);

        return response()->streamDownload(function() use ($mpdf) {
            $mpdf->Output();
        }, $this->getFileName());
    }

    private function getFileName(): string {
        return $this->invoice->created_at->format('Y-m-d') . '-' . str_replace(' ', '', $this->invoice->sf_code) . '.pdf';
    }
}
