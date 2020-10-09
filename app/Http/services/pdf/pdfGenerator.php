<?php


namespace App\Http\services\pdf;


class pdfGenerator
{

    public function generatePdf($view = 'pdf.invoice')
    {
        $html = view($view)->render();

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
